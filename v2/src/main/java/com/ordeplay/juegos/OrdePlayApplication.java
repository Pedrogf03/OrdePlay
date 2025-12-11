package com.ordeplay.juegos;

import com.ordeplay.juegos.model.AuthProvider;
import com.ordeplay.juegos.model.Usuario;
import com.ordeplay.juegos.repository.UsuarioRepository;
import org.springframework.boot.CommandLineRunner;
import org.springframework.boot.SpringApplication;
import org.springframework.boot.autoconfigure.SpringBootApplication;
import org.springframework.context.annotation.Bean;

@SpringBootApplication
public class OrdePlayApplication {

  public static void main(String[] args) {
    SpringApplication.run(OrdePlayApplication.class, args);
  }

  // Esto se ejecuta al arrancar
  @Bean
  CommandLineRunner initData(UsuarioRepository usuarioRepo) {
    return args -> {
      // 1. Crear un usuario de prueba si no existe
      String emailPrueba = "pedro@test.com";

      if (usuarioRepo.findByEmail(emailPrueba).isEmpty()) {
        Usuario usuario = Usuario.builder()
            .email(emailPrueba)
            .nombre("Pedro Gamer")
            .proveedor(AuthProvider.LOCAL)
            .build();

        usuarioRepo.save(usuario);
        System.out.println("✅ USUARIO DE PRUEBA CREADO EN BBDD: " + usuario.getEmail());
      } else {
        System.out.println("ℹ️ El usuario de prueba ya existía.");
      }
    };
  }
}