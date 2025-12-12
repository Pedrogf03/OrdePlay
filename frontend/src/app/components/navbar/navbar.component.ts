import { Component, EventEmitter, Output } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';

@Component({
  selector: 'app-navbar',
  standalone: true,
  imports: [CommonModule, FormsModule],
  templateUrl: './navbar.component.html',
  styleUrl: './navbar.component.css'
})
export class NavbarComponent {
  searchTerm: string = '';
  selectedGenre: string = '';
  selectedPlatform: string = '';
  
  isLoggedIn: boolean = false; 
  userProfileImage: string = 'https://i.pravatar.cc/150?img=11';

  @Output() onSearch = new EventEmitter<any>(); // Emitimos objeto con todos los filtros
  @Output() onMenuToggle = new EventEmitter<void>();

  // Listas oficiales de IGDB (IDs reales)
  genres = [
    { id: 4, name: 'Lucha' },
    { id: 31, name: 'Aventura' },
    { id: 33, name: 'Arcade' },
    { id: 5, name: 'Shooter' },
    { id: 12, name: 'RPG' },
    { id: 14, name: 'Deportes' },
    { id: 10, name: 'Carreras' }
  ];

  platforms = [
    { id: 6, name: 'PC' },
    { id: 48, name: 'PS4' },
    { id: 167, name: 'PS5' },
    { id: 49, name: 'Xbox One' },
    { id: 130, name: 'Switch' }
  ];

  triggerSearch() {
    // Enviamos todo junto: texto, género y plataforma
    this.onSearch.emit({
      query: this.searchTerm,
      genre: this.selectedGenre,
      platform: this.selectedPlatform
    });
  }

  toggleMenu() {
    this.onMenuToggle.emit();
  }
}