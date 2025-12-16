import { Component, Output, EventEmitter } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms'; 
import { AuthService } from '../../services/auth.service'; // <--- IMPORTANTE

@Component({
  selector: 'app-navbar',
  standalone: true,
  imports: [CommonModule, FormsModule],
  templateUrl: './navbar.component.html',
  styleUrl: './navbar.component.css'
})
export class NavbarComponent {

  // Eventos hacia el padre (App Component)
  @Output() onSearch = new EventEmitter<any>();
  @Output() onMenuToggle = new EventEmitter<void>();
  @Output() onLoginClick = new EventEmitter<void>(); // <--- Nuevo evento para abrir el modal

  // Variables del Buscador
  searchTerm: string = '';
  selectedGenre: string = '0';
  selectedPlatform: string = '0';

  // Variables de Usuario (Las que daban error)
  isLoggedIn: boolean = false;
  userProfileImage: string = '';
  username: string = ''; 

  // --- DATOS DUROS (IDs REALES DE IGDB) ---
  genres = [
    { id: '4', name: '🥊 Lucha' },
    { id: '5', name: '🔫 Shooter' },
    { id: '8', name: '🏃 Plataformas' },
    { id: '12', name: '⚔️ RPG (Rol)' },
    { id: '14', name: '⚽ Deportes' },
    { id: '15', name: '🧠 Estrategia' },
    { id: '31', name: '🌍 Aventura' },
    { id: '32', name: '🎨 Indie' },
    { id: '33', name: '🕹️ Arcade' },
    { id: '2', name: '🚀 Point-and-click' }
  ];

  platforms = [
    { id: '6', name: '💻 PC (Windows)' },
    { id: '167', name: '🎮 PlayStation 5' },
    { id: '48', name: '🎮 PlayStation 4' },
    { id: '169', name: '❎ Xbox Series X|S' },
    { id: '49', name: '❎ Xbox One' },
    { id: '130', name: '🍄 Nintendo Switch' },
    { id: '34', name: '🤖 Android' },
    { id: '14', name: '🍎 Mac' }
  ];

  constructor(private authService: AuthService) {
    // Nos suscribimos al AuthService para saber si cambia el estado
    // Esto rellena las variables username y userProfileImage automáticamente
    this.authService.currentUser$.subscribe(user => {
      if (user) {
        this.isLoggedIn = true;
        this.username = user.username;
        this.userProfileImage = user.avatar;
      } else {
        this.isLoggedIn = false;
        this.username = '';
        this.userProfileImage = '';
      }
    });
  }

  // --- FUNCIONES ---

  triggerSearch() {
    this.onSearch.emit({
      query: this.searchTerm,
      genre: this.selectedGenre,
      platform: this.selectedPlatform
    });
  }

  toggleMenu() {
    this.onMenuToggle.emit();
  }

  // Esta función arregla el error "Property 'handleLoginClick' does not exist"
  handleLoginClick() {
    this.onLoginClick.emit();
  }
  
  // Esta función arregla el error "Property 'logout' does not exist"
  logout() {
    this.authService.logout();
  }
}