package com.ordeplay.juegos.controller;

import com.ordeplay.juegos.model.Usuario;
import com.ordeplay.juegos.repository.UsuarioRepository;
import io.jsonwebtoken.Jwts;
import io.jsonwebtoken.SignatureAlgorithm;
import io.jsonwebtoken.security.Keys;
import org.springframework.beans.factory.annotation.Value;
import org.springframework.http.ResponseEntity;
import org.springframework.security.crypto.password.PasswordEncoder;
import org.springframework.web.bind.annotation.*;

import java.security.Key;
import java.util.Date;
import java.util.HashMap;
import java.util.Map;
import java.util.Optional;

@RestController
@RequestMapping("/api/auth")
@CrossOrigin(origins = "*")
public class AuthController {

  private final UsuarioRepository usuarioRepository;
  private final PasswordEncoder passwordEncoder;

  @Value("${jwt.secret.key}")
  private String secretKey;

  @Value("${jwt.expiration}")
  private long jwtExpiration;

  public AuthController(UsuarioRepository usuarioRepository, PasswordEncoder passwordEncoder) {
    this.usuarioRepository = usuarioRepository;
    this.passwordEncoder = passwordEncoder;
  }

  // --- REGISTRO ---
  @PostMapping("/register")
  public ResponseEntity<?> registrarUsuario(@RequestBody Map<String, String> payload) {
    String username = payload.get("username");
    String password = payload.get("password");
    String email = payload.get("email");

    if (usuarioRepository.existsByEmail(email)) {
      return ResponseEntity.badRequest()
          .body("Error: El email ya está registrado. Usa el login social o inicia sesión.");
    }

    Usuario nuevoUsuario = Usuario.builder()
        .username(username)
        .email(email)
        .password(passwordEncoder.encode(password))
        .avatarUrl("https://api.dicebear.com/7.x/avataaars/svg?seed=" + username)
        .build();

    usuarioRepository.save(nuevoUsuario);

    return ResponseEntity.ok(Map.of("message", "Usuario registrado con éxito"));
  }

  // --- LOGIN ---
  @PostMapping("/login")
  public ResponseEntity<?> login(@RequestBody Map<String, String> payload) {
    String username = payload.get("username");
    String password = payload.get("password");

    Optional<Usuario> userOpt = usuarioRepository.findByUsername(username);

    if (userOpt.isPresent()) {
      Usuario usuario = userOpt.get();
      if (passwordEncoder.matches(password, usuario.getPassword())) {

        String token = generarToken(username);

        Map<String, Object> response = new HashMap<>();
        response.put("token", token);
        response.put("username", usuario.getUsername());
        response.put("avatar", usuario.getAvatarUrl());

        return ResponseEntity.ok(response);
      }
    }
    return ResponseEntity.status(401).body("Credenciales incorrectas");
  }

  private String generarToken(String username) {
    Key key = Keys.hmacShaKeyFor(secretKey.getBytes());
    return Jwts.builder()
        .setSubject(username)
        .setIssuedAt(new Date())
        .setExpiration(new Date(System.currentTimeMillis() + jwtExpiration))
        .signWith(key, SignatureAlgorithm.HS512)
        .compact();
  }
}