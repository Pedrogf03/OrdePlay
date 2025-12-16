package com.ordeplay.juegos.service;

import com.fasterxml.jackson.databind.JsonNode;
import com.ordeplay.juegos.model.ItemLista;
import com.ordeplay.juegos.model.Lista;
import com.ordeplay.juegos.model.Usuario;
import com.ordeplay.juegos.repository.ItemListaRepository;
import com.ordeplay.juegos.repository.ListaRepository;
import com.ordeplay.juegos.repository.UsuarioRepository;
import org.springframework.beans.factory.annotation.Value;
import org.springframework.cache.annotation.Cacheable;
import org.springframework.http.HttpEntity;
import org.springframework.http.HttpHeaders;
import org.springframework.http.MediaType;
import org.springframework.http.ResponseEntity;
import org.springframework.stereotype.Service;
import org.springframework.transaction.annotation.Transactional;
import org.springframework.web.client.RestTemplate;

import java.util.ArrayList;
import java.util.List;
import java.util.Map;

@Service
public class JuegoService {

  private final ListaRepository listaRepo;
  private final ItemListaRepository itemRepo;
  private final UsuarioRepository usuarioRepo;
  private final RestTemplate restTemplate;

  @Value("${igdb.client.id}")
  private String clientId;

  @Value("${igdb.client.secret}")
  private String clientSecret;

  @Value("${igdb.auth.url}")
  private String authUrl;

  @Value("${igdb.api.url}")
  private String apiUrl;

  private String accessToken = null;

  public JuegoService(ListaRepository listaRepo, ItemListaRepository itemRepo, UsuarioRepository usuarioRepo) {
    this.listaRepo = listaRepo;
    this.itemRepo = itemRepo;
    this.usuarioRepo = usuarioRepo;
    this.restTemplate = new RestTemplate();
  }

  // ==========================================
  // PARTE 1: GESTIÓN DE BASE DE DATOS LOCAL
  // ==========================================

  public Lista crearLista(String nombreLista, Long usuarioId) {
    Usuario usuario = usuarioRepo.findById(usuarioId)
        .orElseThrow(() -> new RuntimeException("Usuario no encontrado con ID: " + usuarioId));

    Lista nuevaLista = Lista.builder()
        .nombre(nombreLista)
        .usuario(usuario)
        .build();

    return listaRepo.save(nuevaLista);
  }

  public ItemLista agregarJuego(Long listaId, Long gameId) {
    Lista lista = listaRepo.findById(listaId)
        .orElseThrow(() -> new RuntimeException("Lista no encontrada"));

    if (itemRepo.existsByListaIdAndRawgGameId(listaId, gameId)) {
      throw new RuntimeException("El juego ya está en esta lista");
    }

    ItemLista item = ItemLista.builder()
        .lista(lista)
        .rawgGameId(gameId)
        .build();

    return itemRepo.save(item);
  }

  // ==========================================
  // PARTE 2: COMUNICACIÓN CON IGDB (API EXTERNA)
  // ==========================================

  private String getAccessToken() {
    if (accessToken != null)
      return accessToken;

    String url = authUrl + "?client_id=" + clientId + "&client_secret=" + clientSecret
        + "&grant_type=client_credentials";

    try {
      ResponseEntity<Map> response = restTemplate.postForEntity(url, null, Map.class);
      accessToken = (String) response.getBody().get("access_token");
      System.out.println("🔑 Nuevo Token de Twitch obtenido con éxito.");
      return accessToken;
    } catch (Exception e) {
      throw new RuntimeException(
          "Error crítico: No se pudo autenticar con Twitch/IGDB. Revisa tu Client ID/Secret. " + e.getMessage());
    }
  }

  private HttpHeaders createHeaders() {
    String token = getAccessToken();
    HttpHeaders headers = new HttpHeaders();
    headers.set("Client-ID", clientId);
    headers.set("Authorization", "Bearer " + token);
    headers.setContentType(MediaType.TEXT_PLAIN);
    headers.set("User-Agent", "OrdePlay-App/1.0");
    headers.set("Accept", "application/json");
    return headers;
  }

  // 1. OBTENER JUEGOS DE UNA LISTA (BATCH OPTIMIZADO)
  @Transactional(readOnly = true)
  public List<Object> obtenerJuegosDeLista(Long listaId) {
    Lista lista = listaRepo.findById(listaId)
        .orElseThrow(() -> new RuntimeException("Lista no encontrada"));

    if (lista.getItems().isEmpty()) {
      return new ArrayList<>();
    }

    List<Long> ids = lista.getItems().stream()
        .map(ItemLista::getRawgGameId)
        .toList();

    String idsString = ids.toString().replace("[", "(").replace("]", ")");

    String queryBody = "fields name, cover.url, total_rating, first_release_date; " +
        "where id = " + idsString + "; " +
        "limit 100;";

    return callIgdbApi(queryBody);
  }

  // 2. BUSCADOR DE JUEGOS
  public List<Object> descubrirJuegos(String consulta, String plataforma, String genero, int offset) {

    StringBuilder query = new StringBuilder();

    if (consulta != null && !consulta.isEmpty()) {
      query.append("search \"").append(consulta.replace("\"", "")).append("\"; ");
    }

    query.append("fields name, cover.url, total_rating, first_release_date, platforms.name, genres.name; ");

    StringBuilder whereClause = new StringBuilder();
    whereClause.append("where cover != null");

    if (plataforma != null && !plataforma.isEmpty() && !plataforma.equals("0")) {
      whereClause.append(" & platforms = ").append(plataforma);
    }

    if (genero != null && !genero.isEmpty() && !genero.equals("0")) {
      whereClause.append(" & genres = ").append(genero);
    }

    query.append(whereClause).append("; ");

    if (consulta == null || consulta.isEmpty()) {
      query.append("sort first_release_date desc; ");
    }

    query.append("limit 12; offset ").append(offset).append(";");

    return callIgdbApi(query.toString());
  }

  // 3. NOVEDADES (CACHÉ ACTIVADA)
  @Cacheable(value = "novedades", key = "#a0")
  public List<Object> obtenerUltimosLanzamientos(int offset) {

    long unixTime = System.currentTimeMillis() / 1000L;

    String queryBody = "fields name, cover.url, total_rating, first_release_date; " +
        "where first_release_date < " + unixTime + " & cover != null; " +
        "sort first_release_date desc; " +
        "limit 12; " +
        "offset " + offset + ";";

    return callIgdbApi(queryBody);
  }

  // --- MÉTODO CENTRALIZADO PARA LLAMAR A LA API ---
  private List<Object> callIgdbApi(String queryBody) {
    try {
      HttpHeaders headers = createHeaders();
      HttpEntity<String> request = new HttpEntity<>(queryBody, headers);

      ResponseEntity<JsonNode> response = restTemplate.postForEntity(apiUrl, request, JsonNode.class);

      List<Object> resultados = new ArrayList<>();
      if (response.getBody() != null && response.getBody().isArray()) {
        for (JsonNode nodo : response.getBody()) {
          resultados.add(nodo);
        }
      }
      return resultados;

    } catch (Exception e) {
      this.accessToken = null;
      System.err.println("❌ Error llamando a IGDB: " + e.getMessage());
      throw new RuntimeException("Error fetching games from IGDB: " + e.getMessage());
    }
  }
}