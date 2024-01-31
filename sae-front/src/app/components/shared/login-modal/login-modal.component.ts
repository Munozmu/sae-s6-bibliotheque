import { CommonModule } from '@angular/common';
import { Component, EventEmitter, Output } from '@angular/core';

@Component({
  selector: 'app-login-modal',
  standalone: true,
  imports: [CommonModule],
  templateUrl: './login-modal.component.html',
  styleUrl: './login-modal.component.scss'
})
export class LoginModalComponent {

  @Output() modalClosed: EventEmitter<boolean> = new EventEmitter<boolean>();

  registered: boolean = false;

  constructor() { }

  switchRegistration() {
    this.registered = !this.registered;
  }

  onCloseModal() {
    this.modalClosed.emit(true);
  }

}
