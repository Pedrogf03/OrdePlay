import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';
import { Game } from '../models/game.interface';

@Injectable({
  providedIn: 'root'
})
export class GameService {
  private apiUrl = 'http://localhost:8080/api';

  constructor(private http: HttpClient) { }

  searchGames(query: string): Observable<Game[]> {
    return this.http.get<Game[]>(`${this.apiUrl}/buscar?q=${query}`);
  }

  getLatestGames(offset: number = 0): Observable<Game[]> {
    return this.http.get<Game[]>(`${this.apiUrl}/novedades?offset=${offset}`);
  }
}