package com.ordeplay.juegos.repository;

import com.ordeplay.juegos.model.ItemLista;
import org.springframework.data.jpa.repository.JpaRepository;

public interface ItemListaRepository extends JpaRepository<ItemLista, Long> {

  boolean existsByListaIdAndRawgGameId(Long listaId, Long rawgGameId);

}