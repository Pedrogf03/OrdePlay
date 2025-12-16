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

  searchGames(query: string, platform: string, genre: string, offset: number = 0): Observable<Game[]> {
    let params = `?offset=${offset}`;
    if (query) params += `&q=${query}`;
    if (platform && platform !== '0') params += `&plataforma=${platform}`;
    if (genre && genre !== '0') params += `&genero=${genre}`;

    return this.http.get<Game[]>(`${this.apiUrl}/buscar${params}`);
  }

  getLatestGames(offset: number = 0): Observable<Game[]> {
    return this.http.get<Game[]>(`${this.apiUrl}/novedades?offset=${offset}`);
  }
}