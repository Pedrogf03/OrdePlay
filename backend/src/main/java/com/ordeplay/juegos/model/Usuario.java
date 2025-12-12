package com.ordeplay.juegos.model;

import jakarta.persistence.*;
import lombok.AllArgsConstructor;
import lombok.Builder;
import lombok.Data;
import lombok.NoArgsConstructor;
import org.hibernate.annotations.CreationTimestamp;

import java.time.LocalDateTime;

@Entity
@Table(name = "usuario")
@Data // Genera Getters, Setters, toString, etc.
@NoArgsConstructor // Constructor vacío (obligatorio para JPA)
@AllArgsConstructor // Constructor con todo (útil)
@Builder // Patrón Builder (para crear objetos fácilmente)
public class Usuario {

  @Id
  @GeneratedValue(strategy = GenerationType.IDENTITY)
  private Long id;

  @Column(nullable = false, unique = true)
  private String email;

  private String nombre;

  private String fotoPerfilUrl; // Url de la foto de Google/Discord

  // OAUTH2: Identificadores del proveedor
  @Enumerated(EnumType.STRING)
  private AuthProvider proveedor; // GOOGLE, DISCORD, LOCAL

  private String providerId; // El ID único que te da Google (ej: "sub_12345")

  @CreationTimestamp
  @Column(updatable = false)
  private LocalDateTime fechaRegistro;
}