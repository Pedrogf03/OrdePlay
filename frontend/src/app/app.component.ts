import { Component, OnInit, ChangeDetectorRef } from '@angular/core';
import { CommonModule } from '@angular/common';
import { ActivatedRoute, Router } from '@angular/router';
import { NavbarComponent } from './components/navbar/navbar.component';
import { FooterComponent } from './components/footer/footer.component';
import { AuthModalComponent } from './components/auth-modal/auth-modal.component';
import { GameService } from './services/game.service';
import { AuthService } from './services/auth.service';
import { Game } from './models/game.interface';

@Component({
  selector: 'app-root',
  standalone: true,
  imports: [CommonModule, NavbarComponent, FooterComponent, AuthModalComponent],
  templateUrl: './app.component.html',
  styleUrl: './app.component.css'
})
export class AppComponent implements OnInit {
  
  games: Game[] = [];
  offset: number = 0;
  isSidebarOpen: boolean = false;
  isLoading: boolean = false;
  
  currentSearchQuery: string = ''; 
  currentGenre: string = '0';
  currentPlatform: string = '0';

  showLoginModal: boolean = false;
  skeletons: any[] = new Array(12);

  constructor(
    private gameService: GameService,
    private authService: AuthService,
    private route: ActivatedRoute,
    private router: Router,
    private cd: ChangeDetectorRef
  ) {}

  ngOnInit() {
    // 1. ESCUCHAR CAMBIOS EN LA URL (Login Social o Errores)
    this.route.queryParams.subscribe(params => {
      
      // CASO A: ERROR DE CUENTA DUPLICADA
      if (params['error'] === 'email_taken') {
        alert("⚠️ Este correo ya está registrado con otro método (Google o Manual).\n\nPor favor, inicia sesión con tu método original.");
        
        // Limpiamos la URL
        this.router.navigate([], { queryParams: { 'error': null }, queryParamsHandling: 'merge' });
        // Opcional: Abrir el modal de login automáticamente
        this.openLoginModal(); 
      }

      // CASO B: LOGIN EXITOSO
      const token = params['token'];
      const username = params['username'];
      const avatar = params['avatar'];

      if (token && username) {
        console.log("🎟️ Login Social detectado:", username);
        
        localStorage.setItem('token', token);
        
        const userData = { 
          username: username, 
          avatar: avatar || 'https://via.placeholder.com/50'
        };
        localStorage.setItem('user', JSON.stringify(userData));
        
        this.router.navigate([], {
          queryParams: { 'token': null, 'username': null, 'avatar': null },
          queryParamsHandling: 'merge'
        }).then(() => {
           window.location.reload();
        });
      }
    });

    // 2. CARGAR JUEGOS
    this.loadMoreGames();
  }

  loadMoreGames() {
    this.isLoading = true;
    this.cd.detectChanges();

    const hasFilters = this.currentSearchQuery || 
                       (this.currentGenre && this.currentGenre !== '0') || 
                       (this.currentPlatform && this.currentPlatform !== '0');

    if (hasFilters) {
      this.gameService.searchGames(
        this.currentSearchQuery, 
        this.currentPlatform, 
        this.currentGenre, 
        this.offset
      ).subscribe({
        next: (data) => this.processData(data),
        error: (err) => this.handleError(err)
      });
    } else {
      this.gameService.getLatestGames(this.offset).subscribe({
        next: (data) => this.processData(data),
        error: (err) => this.handleError(err)
      });
    }
  }

  handleSearch(filters: any) {
    this.currentSearchQuery = filters.query; 
    this.currentGenre = filters.genre;
    this.currentPlatform = filters.platform;
    this.games = []; 
    this.offset = 0;
    this.loadMoreGames();
  }

  openLoginModal() {
    this.showLoginModal = true;
  }

  processData(newGames: Game[]) {
    this.games = [...this.games, ...newGames];
    this.offset += 12;
    this.isLoading = false;
    this.cd.detectChanges();
  }

  handleError(err: any) {
    console.error("Error cargando juegos:", err);
    this.isLoading = false;
    this.cd.detectChanges();
  }

  toggleSidebar() {
    this.isSidebarOpen = !this.isSidebarOpen;
  }

  getCoverUrl(url: string | undefined): string {
    if (!url) return 'https://via.placeholder.com/264x352?text=No+Cover';
    return 'https:' + url.replace('t_thumb', 't_cover_big');
  }
}