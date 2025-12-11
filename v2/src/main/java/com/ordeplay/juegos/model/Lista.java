package com.ordeplay.juegos.model;

import jakarta.persistence.*;
import lombok.*;
import org.hibernate.annotations.CreationTimestamp;
import java.time.LocalDateTime;
import java.util.List;

@Entity
@Table(name = "listas")
@Data
@NoArgsConstructor
@AllArgsConstructor
@Builder
public class Lista {

  @Id
  @GeneratedValue(strategy = GenerationType.IDENTITY)
  private Long id;

  @Column(nullable = false)
  private String nombre; // Ej: "Juegos de Terror", "Favoritos"

  @CreationTimestamp
  private LocalDateTime fechaCreacion;

  // RELACIONES

  // Muchas listas pertenecen a UN usuario
  @ManyToOne(fetch = FetchType.LAZY)
  @JoinColumn(name = "usuario_id", nullable = false)
  private Usuario usuario;

  // Una lista tiene MUCHOS items (juegos)
  // "cascade = ALL" significa que si borras la lista, se borran los items de dentro
  @OneToMany(mappedBy = "lista", cascade = CascadeType.ALL, orphanRemoval = true)
  private List<ItemLista> items;
}