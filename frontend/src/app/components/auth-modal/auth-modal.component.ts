import { Component, EventEmitter, Output, ChangeDetectorRef } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';
import { AuthService } from '../../services/auth.service';

@Component({
  selector: 'app-auth-modal',
  standalone: true,
  imports: [CommonModule, FormsModule],
  templateUrl: './auth-modal.component.html',
  styleUrl: './auth-modal.component.css'
})
export class AuthModalComponent {
  
  @Output() close = new EventEmitter<void>();

  isLoginMode: boolean = true; 
  isLoading: boolean = false;
  errorMessage: string = '';

  // Datos del formulario
  formData = {
    username: '',
    email: '',
    password: ''
  };

  constructor(
    private authService: AuthService,
    private cd: ChangeDetectorRef // <--- VITAL PARA QUE NO SE QUEDE CARGANDO
  ) {}

  toggleMode() {
    this.isLoginMode = !this.isLoginMode;
    this.errorMessage = '';
    this.cd.detectChanges();
  }

  onSubmit() {
    this.isLoading = true;
    this.errorMessage = '';
    this.cd.detectChanges(); // Forzamos vista de carga

    if (this.isLoginMode) {
      // --- LOGIN ---
      this.authService.login(this.formData).subscribe({
        next: () => {
          this.isLoading = false;
          this.close.emit(); 
        },
        error: (err) => {
          this.isLoading = false;
          // Mostramos el mensaje del backend si existe, o uno genérico
          this.errorMessage = err.error || 'Usuario o contraseña incorrectos';
          this.cd.detectChanges(); // <--- ACTUALIZAMOS VISTA
        }
      });
    } else {
      // --- REGISTRO ---
      this.authService.register(this.formData).subscribe({
        next: () => {
          this.isLoading = false;
          this.isLoginMode = true; 
          this.errorMessage = '¡Cuenta creada! Ahora inicia sesión.';
          this.cd.detectChanges(); // <--- ACTUALIZAMOS VISTA
        },
        error: (err) => {
          this.isLoading = false;
          // Aquí capturamos el texto exacto que manda AuthController:
          // "Error: El email ya está registrado..."
          this.errorMessage = err.error || 'Error al registrarse. Inténtalo de nuevo.';
          this.cd.detectChanges(); // <--- ACTUALIZAMOS VISTA (Mata el spinner)
        }
      });
    }
  }

  closeModal() {
    this.close.emit();
  }
}