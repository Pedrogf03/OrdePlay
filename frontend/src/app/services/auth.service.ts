import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { BehaviorSubject, Observable, tap } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class AuthService {

  private apiUrl = 'http://localhost:8080/api/auth';
  
  // "Chivato" reactivo: Avisa a toda la app si el usuario está logueado o no
  private currentUserSubject = new BehaviorSubject<any>(null);
  public currentUser$ = this.currentUserSubject.asObservable();

  constructor(private http: HttpClient) {
    // Al iniciar, comprobamos si ya había un token guardado
    this.checkToken();
  }

  // Verificar si hay sesión guardada en el navegador
  private checkToken() {
    const token = localStorage.getItem('token');
    const user = localStorage.getItem('user');
    if (token && user) {
      this.currentUserSubject.next(JSON.parse(user));
    }
  }

  // --- LOGIN ---
  login(credentials: any): Observable<any> {
    return this.http.post(`${this.apiUrl}/login`, credentials).pipe(
      tap((response: any) => {
        // Guardamos el token y el usuario en el navegador
        localStorage.setItem('token', response.token);
        const userData = { username: response.username, avatar: response.avatar };
        localStorage.setItem('user', JSON.stringify(userData));
        
        // Avisamos a la app que hay usuario nuevo
        this.currentUserSubject.next(userData);
      })
    );
  }

  // --- REGISTRO ---
  register(data: any): Observable<any> {
    return this.http.post(`${this.apiUrl}/register`, data);
  }

  // --- LOGOUT ---
  logout() {
    localStorage.removeItem('token');
    localStorage.removeItem('user');
    this.currentUserSubject.next(null);
  }

  // Método simple para saber si está logueado
  isLoggedIn(): boolean {
    return !!localStorage.getItem('token');
  }
  
  // Obtener token (para futuras peticiones)
  getToken(): string | null {
    return localStorage.getItem('token');
  }
}