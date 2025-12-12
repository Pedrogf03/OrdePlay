package com.ordeplay.juegos.config;

import com.ordeplay.juegos.service.JuegoService;
import org.springframework.boot.context.event.ApplicationReadyEvent;
import org.springframework.context.event.EventListener;
import org.springframework.stereotype.Component;

@Component
public class CacheWarmer {

  private final JuegoService juegoService;

  public CacheWarmer(JuegoService juegoService) {
    this.juegoService = juegoService;
  }

  @EventListener(ApplicationReadyEvent.class)
  public void calentarCache() {
    System.out.println("🔥 Calentando motores... Descargando juegos de IGDB en segundo plano...");

    try {
      juegoService.obtenerUltimosLanzamientos(0);
      System.out.println("✅ ¡Caché lista! La primera visita será instantánea.");
    } catch (Exception e) {
      System.out.println("⚠️ No se pudo calentar la caché (¿Sin internet?): " + e.getMessage());
    }
  }
}