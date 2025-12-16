package com.ordeplay.juegos.config;

import com.ordeplay.juegos.model.Usuario;
import com.ordeplay.juegos.repository.UsuarioRepository;
import io.jsonwebtoken.Jwts;
import io.jsonwebtoken.SignatureAlgorithm;
import io.jsonwebtoken.security.Keys;
import jakarta.servlet.ServletException;
import jakarta.servlet.http.HttpServletRequest;
import jakarta.servlet.http.HttpServletResponse;
import org.springframework.beans.factory.annotation.Value;
import org.springframework.security.core.Authentication;
import org.springframework.security.oauth2.client.authentication.OAuth2AuthenticationToken;
import org.springframework.security.oauth2.core.user.OAuth2User;
import org.springframework.security.web.authentication.SimpleUrlAuthenticationSuccessHandler;
import org.springframework.stereotype.Component;

import java.io.IOException;
import java.net.URLEncoder;
import java.nio.charset.StandardCharsets;
import java.security.Key;
import java.util.Date;
import java.util.Optional;
import java.util.UUID;

@Component
public class OAuth2SuccessHandler extends SimpleUrlAuthenticationSuccessHandler {

  private final UsuarioRepository usuarioRepository;

  @Value("${jwt.secret.key}")
  private String secretKey;

  @Value("${jwt.expiration}")
  private long jwtExpiration;

  public OAuth2SuccessHandler(UsuarioRepository usuarioRepository) {
    this.usuarioRepository = usuarioRepository;
  }

  @Override
  public void onAuthenticationSuccess(HttpServletRequest request, HttpServletResponse response,
      Authentication authentication) throws IOException, ServletException {
    OAuth2AuthenticationToken authToken = (OAuth2AuthenticationToken) authentication;
    OAuth2User oAuth2User = authToken.getPrincipal();

    // Identificar proveedor ("google" o "discord")
    String registrationId = authToken.getAuthorizedClientRegistrationId();

    // 1. EXTRAER DATOS
    String email = oAuth2User.getAttribute("email");
    String name = oAuth2User.getAttribute("name");
    String providerId = null;
    String avatarUrl = null;

    // Lógica específica por proveedor
    if ("google".equals(registrationId)) {
      providerId = oAuth2User.getAttribute("sub");
      avatarUrl = oAuth2User.getAttribute("picture");
    } else if ("discord".equals(registrationId)) {
      providerId = oAuth2User.getAttribute("id");
      String avatarHash = oAuth2User.getAttribute("avatar");
      if (avatarHash != null) {
        avatarUrl = "https://cdn.discordapp.com/avatars/" + providerId + "/" + avatarHash + ".png";
      }
      if (name == null)
        name = oAuth2User.getAttribute("username");
    }

    // Fallbacks
    if (email == null)
      email = providerId + "@discord.user";
    if (avatarUrl == null)
      avatarUrl = "https://api.dicebear.com/7.x/avataaars/svg?seed=" + (name != null ? name : "user");

    // 2. LÓGICA ESTRICTA (NO VINCULAR AUTOMÁTICAMENTE)
    Usuario usuario;
    Optional<Usuario> userOpt = usuarioRepository.findByEmail(email);

    if (userOpt.isPresent()) {
      usuario = userOpt.get();

      // VERIFICACIÓN DE SEGURIDAD:
      // ¿El usuario ya tiene vinculado ESTE servicio?
      boolean esCuentaVinculada = false;

      if ("google".equals(registrationId) && providerId.equals(usuario.getGoogleId())) {
        esCuentaVinculada = true;
      } else if ("discord".equals(registrationId) && providerId.equals(usuario.getDiscordId())) {
        esCuentaVinculada = true;
      }

      // SI NO ESTÁ VINCULADA -> RECHAZAR ACCESO
      if (!esCuentaVinculada) {
        // Redirigimos al frontend con un error específico
        getRedirectStrategy().sendRedirect(request, response, "http://localhost:4200?error=email_taken");
        return; // Cortamos ejecución aquí
      }

      // Si pasa la verificación, actualizamos foto (opcional) y seguimos
      usuario.setAvatarUrl(avatarUrl);
      usuarioRepository.save(usuario);

    } else {
      // USUARIO NUEVO -> CREARLO
      usuario = Usuario.builder()
          .username(name)
          .email(email)
          .password(UUID.randomUUID().toString())
          .avatarUrl(avatarUrl)
          .provider(registrationId.toUpperCase())
          .build();

      // Asignamos el ID al campo que toca
      if ("google".equals(registrationId))
        usuario.setGoogleId(providerId);
      if ("discord".equals(registrationId))
        usuario.setDiscordId(providerId);

      usuarioRepository.save(usuario);
    }

    // 3. ÉXITO: GENERAR TOKEN Y REDIRIGIR
    String token = generarToken(usuario.getUsername());
    String encodedName = URLEncoder.encode(usuario.getUsername(), StandardCharsets.UTF_8);
    String encodedAvatar = URLEncoder.encode(usuario.getAvatarUrl(), StandardCharsets.UTF_8);

    String redirectUrl = "http://localhost:4200?token=" + token +
        "&username=" + encodedName +
        "&avatar=" + encodedAvatar;

    getRedirectStrategy().sendRedirect(request, response, redirectUrl);
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