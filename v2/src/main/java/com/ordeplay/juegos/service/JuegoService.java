package com.ordeplay.juegos.service;

import com.fasterxml.jackson.databind.JsonNode;
import com.ordeplay.juegos.model.ItemLista;
import com.ordeplay.juegos.model.Lista;
import com.ordeplay.juegos.model.Usuario;
import com.ordeplay.juegos.repository.ItemListaRepository;
import com.ordeplay.juegos.repository.ListaRepository;
import com.ordeplay.juegos.repository.UsuarioRepository;
import org.springframework.beans.factory.annotation.Value;
import org.springframework.http.HttpEntity;
import org.springframework.http.HttpHeaders;
import org.springframework.http.MediaType;
import org.springframework.http.ResponseEntity;
import org.springframework.stereotype.Service;
import org.springframework.web.client.RestTemplate;
import org.springframework.transaction.annotation.Transactional;

import java.util.ArrayList;
import java.util.List;
import java.util.Map;

@Service
public class JuegoService {

  private final ListaRepository listaRepo;
  private final ItemListaRepository itemRepo;
  private final UsuarioRepository usuarioRepo;

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
  }

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

  private String getAccessToken() {
    if (accessToken != null)
      return accessToken;

    RestTemplate restTemplate = new RestTemplate();

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

  @Transactional(readOnly = true)
  public List<Object> obtenerJuegosDeLista(Long listaId) {

    Lista lista = listaRepo.findById(listaId)
        .orElseThrow(() -> new RuntimeException("Lista no encontrada"));

    List<Object> juegosDetallados = new ArrayList<>();
    RestTemplate restTemplate = new RestTemplate();

    String token = getAccessToken();
    HttpHeaders headers = new HttpHeaders();
    headers.set("Client-ID", clientId);
    headers.set("Authorization", "Bearer " + token);
    headers.setContentType(MediaType.TEXT_PLAIN);

    for (ItemLista item : lista.getItems()) {
      try {
        String queryBody = "fields name, cover.url, total_rating; where id = " + item.getRawgGameId() + ";";

        HttpEntity<String> request = new HttpEntity<>(queryBody, headers);

        ResponseEntity<JsonNode> response = restTemplate.postForEntity(apiUrl, request, JsonNode.class);

        if (response.getBody() != null && response.getBody().isArray() && !response.getBody().isEmpty()) {
          juegosDetallados.add(response.getBody().get(0));
        }

      } catch (Exception e) {
        System.err.println("Error buscando juego ID " + item.getRawgGameId() + ": " + e.getMessage());
        this.accessToken = null;
      }
    }
    return juegosDetallados;
  }

  public List<Object> buscarJuegos(String consulta) {
    RestTemplate restTemplate = new RestTemplate();
    String token = getAccessToken();

    HttpHeaders headers = new HttpHeaders();
    headers.set("Client-ID", clientId);
    headers.set("Authorization", "Bearer " + token);
    headers.setContentType(MediaType.TEXT_PLAIN);

    // Limpiamos comillas para evitar errores de sintaxis en IGDB
    String cleanQuery = consulta.replace("\"", "");

    // Construimos la query solo con SEARCH y FIELDS
    // Nota: Quitamos el 'where total_rating...'
    String queryBody = "search \"" + cleanQuery + "\"; " +
        "fields name, cover.url, total_rating, first_release_date, platforms.name; " +
        "limit 10;";

    try {
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
      this.accessToken = null; // Reseteamos token por si acaso
      throw new RuntimeException("Error en la búsqueda: " + e.getMessage());
    }
  }

}