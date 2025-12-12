package com.ordeplay.juegos;

import org.springframework.boot.SpringApplication;
import org.springframework.boot.autoconfigure.SpringBootApplication;
import org.springframework.cache.annotation.EnableCaching;

@SpringBootApplication
@EnableCaching
public class OrdePlayApplication {

  public static void main(String[] args) {
    SpringApplication.run(OrdePlayApplication.class, args);
  }

}