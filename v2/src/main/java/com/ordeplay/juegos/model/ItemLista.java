package com.ordeplay.juegos.model;

import jakarta.persistence.*;
import lombok.*;
import org.hibernate.annotations.CreationTimestamp;
import java.time.LocalDateTime;

@Entity
@Table(name = "items_lista")
@Data
@NoArgsConstructor
@AllArgsConstructor
@Builder
public class ItemLista {

  @Id
  @GeneratedValue(strategy = GenerationType.IDENTITY)
  private Long id;

  @Column(nullable = false)
  private Long rawgGameId; // El ID del juego en la API externa (ej: 3498)

  @CreationTimestamp
  private LocalDateTime fechaAgregado;

  // RELACIONES

  // Muchos items pertenecen a UNA lista
  @ManyToOne(fetch = FetchType.LAZY)
  @JoinColumn(name = "lista_id", nullable = false)
  private Lista lista;
}