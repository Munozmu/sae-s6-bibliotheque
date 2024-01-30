import { Component } from '@angular/core';
import { LoginModalComponent } from "../login-modal/login-modal.component";

@Component({
    selector: 'app-navbar',
    standalone: true,
    templateUrl: './navbar.component.html',
    styleUrl: './navbar.component.scss',
    imports: [LoginModalComponent]
})
export class NavbarComponent {

}
