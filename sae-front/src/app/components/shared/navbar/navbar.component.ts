import { Component } from '@angular/core';
import { RouterModule } from '@angular/router';
import { LoginModalComponent } from "../login-modal/login-modal.component";
import { CommonModule } from '@angular/common';

@Component({
  selector: 'app-navbar',
  standalone: true,
  imports: [RouterModule, LoginModalComponent, CommonModule],
  templateUrl: './navbar.component.html',
  styleUrl: './navbar.component.scss',
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
