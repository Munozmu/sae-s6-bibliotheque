import { CommonModule } from '@angular/common';
import { Component, EventEmitter, Output } from '@angular/core';
import { FormBuilder, FormGroup, Validators, ReactiveFormsModule, FormsModule, FormControl, AbstractControl } from '@angular/forms';
import { AuthService } from '../../../core/auth/auth.service';
import { Router } from '@angular/router';

@Component({
  selector: 'app-login-modal',
  standalone: true,
  imports: [CommonModule, FormsModule, ReactiveFormsModule],
  templateUrl: './login-modal.component.html',
  styleUrl: './login-modal.component.scss'
})
export class LoginModalComponent {

  @Output() modalClosed: EventEmitter<boolean> = new EventEmitter<boolean>();

  registered: boolean = true;

  loginForm: FormGroup;
  registrationForm: FormGroup;


  constructor(
    private fb: FormBuilder,
    private authService: AuthService,
    private router: Router
  ) {

    this.loginForm = this.fb.group({
      email: ['', [Validators.required, Validators.email]],
      password: ['', [Validators.required]],
    });

    this.registrationForm = this.fb.group({
      firstName: ['', [Validators.required]],
      lastName: ['', [Validators.required]],
      phone: ['', [Validators.required, Validators.pattern(/^\d{10}$/)]],
      dateOfBirth: ['', [Validators.required]],
      address: ['', [Validators.required]],
      email: ['', [Validators.required, Validators.email]],
      password: ['', [Validators.required]],
    });
  }

  get formControlsRegistration(): { [key: string]: AbstractControl } {
    return this.registrationForm.controls;
  }

  get formControlsLogin(): { [key: string]: AbstractControl } {
    return this.loginForm.controls;
  }

  switchRegistration() {
    this.registered = !this.registered;
  }

  onCloseModal() {
    this.modalClosed.emit(true);
  }

  onSubmitRegister() {
    if (this.registrationForm.valid) {
      console.log('Form submitted:', this.registrationForm.value);
      this.authService.login();
      this.onCloseModal();
      this.router.navigateByUrl('/account');
    } else {
      console.error('Form invalid');
    }
  }

  onSubmitLogin() {
    if (this.loginForm.valid) {
      console.log('Form submitted:', this.loginForm.value);
      this.authService.login();
      this.onCloseModal();
      this.router.navigateByUrl('/account');
    }
    else {
      console.error('Form invalid');
    }
  }

}
