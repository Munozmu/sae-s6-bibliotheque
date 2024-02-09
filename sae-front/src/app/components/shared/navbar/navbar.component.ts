import { Component, OnInit } from '@angular/core';
import { Router, RouterModule } from '@angular/router';
import { LoginModalComponent } from "../login-modal/login-modal.component";
import { CommonModule } from '@angular/common';
import { AuthService } from '../../../core/auth/auth.service';
import { Adherent } from '../../../core/models/adherent';
import { Categories } from '../../../core/models/categories';
import { BookService } from '../../../core/services/book.service';

@Component({
  selector: 'app-navbar',
  standalone: true,
  imports: [RouterModule, LoginModalComponent, CommonModule],
  templateUrl: './navbar.component.html',
  styleUrl: './navbar.component.scss',
})
export class NavbarComponent implements OnInit {

  isLoginModalDisplayed: boolean = false;

  categories: Categories[] = [];

  constructor(
    protected authService: AuthService,
    private router: Router,
    private bookService: BookService
  ) { }

  currentUser$ = this.authService.currentUser$;

  ngOnInit(): void {
    this.authService.refreshCurrentUser();

    this.bookService.getAllCategories().subscribe(categories => {
      this.categories = categories;
    }
    );
  }

  onModalClosed(isClosed: boolean) {
    if (isClosed) this.isLoginModalDisplayed = false;
  }

  openModal() {
    this.isLoginModalDisplayed = true;
  }

  redirectToAccount() {
    this.router.navigateByUrl('/account');
  }

}
