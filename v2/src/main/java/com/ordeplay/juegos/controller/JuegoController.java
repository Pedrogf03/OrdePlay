package com.ordeplay.juegos.controller;

import com.ordeplay.juegos.model.ItemLista;
import com.ordeplay.juegos.model.Lista;
import com.ordeplay.juegos.service.JuegoService;
import org.springframework.web.bind.annotation.*;

import java.util.List;

@RestController
@RequestMapping("/api")
@CrossOrigin(origins = "*")
public class JuegoController {

  private final JuegoService juegoService;

  public JuegoController(JuegoService juegoService) {
    this.juegoService = juegoService;
  }

  @PostMapping("/listas")
  public Lista crearLista(@RequestParam String nombre, @RequestParam Long usuarioId) {
    return juegoService.crearLista(nombre, usuarioId);
  }

  @PostMapping("/listas/{listaId}/agregar")
  public ItemLista agregarJuego(@PathVariable Long listaId, @RequestParam Long gameId) {
    return juegoService.agregarJuego(listaId, gameId);
  }

  @GetMapping("/listas/{listaId}")
  public List<Object> verLista(@PathVariable Long listaId) {
    return juegoService.obtenerJuegosDeLista(listaId);
  }

  @GetMapping("/buscar")
  public List<Object> buscar(@RequestParam("q") String consulta) {
    return juegoService.buscarJuegos(consulta);
  }
}