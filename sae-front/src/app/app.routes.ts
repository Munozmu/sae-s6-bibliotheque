import { Routes } from '@angular/router';
import { HomepageComponent } from './pages/homepage/homepage.component';
import { BookDetailsComponent } from './pages/book-details/book-details.component';
import { UserAccountComponent } from './pages/account/user-account/user-account.component';
import { CatalogComponent } from './pages/catalog/catalog.component';
import { AuthGuard } from './core/auth/guard/auth.guard';

export const routes: Routes = [
  { path: '', component: HomepageComponent },
  { path: 'account', component: UserAccountComponent, canActivate: [AuthGuard] },
  { path: 'search', component: HomepageComponent },
  { path: 'catalog', component: CatalogComponent },
  { path: 'book/:id', component: BookDetailsComponent },
];
