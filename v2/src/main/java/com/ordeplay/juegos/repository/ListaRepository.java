package com.ordeplay.juegos.repository;

import com.ordeplay.juegos.model.Lista;
import org.springframework.data.jpa.repository.JpaRepository;
import java.util.List;

public interface ListaRepository extends JpaRepository<Lista, Long> {

  List<Lista> findByUsuarioId(Long usuarioId);

}