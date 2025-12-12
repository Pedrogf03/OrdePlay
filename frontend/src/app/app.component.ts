import { Component, OnInit, ChangeDetectorRef } from '@angular/core';
import { CommonModule } from '@angular/common';
import { NavbarComponent } from './components/navbar/navbar.component';
import { FooterComponent } from './components/footer/footer.component';
import { GameService } from './services/game.service';
import { Game } from './models/game.interface';

@Component({
  selector: 'app-root',
  standalone: true,
  imports: [CommonModule, NavbarComponent, FooterComponent],
  templateUrl: './app.component.html',
  styleUrl: './app.component.css'
})
export class AppComponent implements OnInit {
  
  games: Game[] = [];
  offset: number = 0;
  isSidebarOpen: boolean = false;
  isLoading: boolean = false;
  
  skeletons: any[] = new Array(12);

  constructor(
    private gameService: GameService,
    private cd: ChangeDetectorRef
  ) {}

  ngOnInit() {
    this.loadMoreGames();
  }

  loadMoreGames() {
    this.isLoading = true;

    this.gameService.getLatestGames(this.offset).subscribe({
      next: (newGames: Game[]) => {
        console.log("✅ Datos recibidos en componente:", newGames.length);
        
        this.games = [...this.games, ...newGames];
        this.offset += 12;
        this.isLoading = false;

        this.cd.detectChanges(); 
      },
      error: (err) => {
        console.error("❌ Error cargando juegos:", err);
        this.isLoading = false;
        this.cd.detectChanges();
      }
    });
  }

  handleSearch(filters: any) {
    this.isLoading = true;
    
    if (filters.query) {
      this.gameService.searchGames(filters.query).subscribe(data => {
        this.games = data;
        this.offset = 0;
        this.isLoading = false;
        this.cd.detectChanges();
      });
    } else {
      this.games = [];
      this.offset = 0;
      this.loadMoreGames();
    }
  }

  toggleSidebar() {
    this.isSidebarOpen = !this.isSidebarOpen;
  }

  getCoverUrl(url: string | undefined): string {
    if (!url) return 'https://via.placeholder.com/264x352?text=No+Cover';
    return 'https:' + url.replace('t_thumb', 't_cover_big');
  }
}