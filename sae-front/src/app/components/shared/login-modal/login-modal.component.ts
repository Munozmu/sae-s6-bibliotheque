import { CommonModule } from '@angular/common';
import { Component, EventEmitter, Output } from '@angular/core';
import { FormBuilder, FormGroup, Validators, ReactiveFormsModule, FormsModule, FormControl, AbstractControl } from '@angular/forms';
import { AuthService } from '../../../core/auth/auth.service';
import { Router } from '@angular/router';
import { AdherentService } from '../../../core/services/adherent.service';

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
    private router: Router,
    private adherentService: AdherentService
  ) {

    this.loginForm = this.fb.group({
      username: ['', [Validators.required, Validators.email]],
      password: ['', [Validators.required]],
    });

    this.registrationForm = this.fb.group({
      prenom: ['', [Validators.required]],
      nom: ['', [Validators.required]],
      numTel: ['', [Validators.required, Validators.pattern(/^\d{10}$/)]],
      dateNaiss: ['', [Validators.required]],
      adressePostale: ['', [Validators.required]],
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

      this.adherentService.postAdherent(this.registrationForm.value).subscribe(
        (adherent) => {
          console.log('Adherent created:', adherent);
          this.authService.login({ username: this.registrationForm.value.email, password: this.registrationForm.value.password });
          this.onCloseModal();
          this.router.navigateByUrl('/account');
        },
        (error) => {
          console.error('Error creating adherent:', error);
        }
      );

    } else {
      console.error('Form invalid');
    }
  }

  onSubmitLogin() {
    if (this.loginForm.valid) {
      console.log('Form submitted:', this.loginForm.value);
      this.authService.login(this.loginForm.value);
      this.onCloseModal();
      this.router.navigateByUrl('/account');
    }
    else {
      console.error('Form invalid');
    }
  }

}
