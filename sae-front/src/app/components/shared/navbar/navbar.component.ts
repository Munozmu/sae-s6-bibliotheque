import { Component } from '@angular/core';
import { LoginModalComponent } from "../login-modal/login-modal.component";
import { CommonModule } from '@angular/common';

@Component({
  selector: 'app-navbar',
  standalone: true,
  templateUrl: './navbar.component.html',
  styleUrl: './navbar.component.scss',
  imports: [LoginModalComponent, CommonModule]
})
export class NavbarComponent {

  isLoginModalDisplayed: boolean = false;

  onModalClosed(isClosed: boolean) {
    if (isClosed) this.isLoginModalDisplayed = false;
  }

  openModal() {
    this.isLoginModalDisplayed = true;
  }

}
