import { NgModule } from "@angular/core";
import { BrowserModule } from "@angular/platform-browser";
import { MatSidenavModule } from "@angular/material/sidenav";
import { MatGridListModule } from "@angular/material/grid-list";
import { MatMenuModule } from "@angular/material/menu";
import { MatButtonModule } from "@angular/material/button";
import { MatCardModule } from "@angular/material/card";
import { MatIconModule } from "@angular/material/icon";
import { MatExpansionModule } from "@angular/material/expansion";
import { MatToolbarModule } from "@angular/material/toolbar";
import { MatTableModule } from "@angular/material/table";
import { MatBadgeModule } from "@angular/material/badge";
import { MatSnackBarModule } from "@angular/material/snack-bar";
import { HttpClientModule } from "@angular/common/http";
import { AppRoutingModule } from "./app-routing.module";
import { AppComponent } from "./app.component";
import { BrowserAnimationsModule } from "@angular/platform-browser/animations";
import { MatListModule } from "@angular/material/list";
import { TranslateModule } from '@ngx-translate/core';
import { HeaderComponent } from "./components/header/header.component";
import { HomeComponent } from "./pages/home/home.component";
import { ProductsHeaderComponent } from './components/products-header/products-header.component';
import { CategoriesComponent } from './components/categories/categories.component';
import { ProductBoxComponent } from './components/product-box/product-box.component';
import { CartComponent } from './pages/cart/cart.component';
import { CollectibleComponent } from "./pages/collectible/collectible.component";
import { CollectiblesComponent } from './pages/collectible/collectibles.component';
import { CartMenuComponent } from "./components/cart-menu/cart-menu.component";
import { PaginationComponent } from "./components/pagination/pagination.component";
import { MatDialogModule } from "@angular/material/dialog";
import { LoginDialogContent } from "./components/header/login-dialog/login-dialog.component";

@NgModule({
  declarations: [
    AppComponent,
    HeaderComponent,
    HomeComponent,
    ProductsHeaderComponent,
    CategoriesComponent,
    ProductBoxComponent,
    PaginationComponent,
    CollectibleComponent,
    CollectiblesComponent,
    CartComponent,
    CartMenuComponent,
    LoginDialogContent,
  ],
  imports: [
    BrowserModule,
    AppRoutingModule,
    BrowserAnimationsModule,
    MatSidenavModule,
    MatGridListModule,
    MatMenuModule,
    MatButtonModule,
    MatCardModule,
    MatDialogModule,
    MatIconModule,
    MatExpansionModule,
    MatListModule,
    MatToolbarModule,
    MatTableModule,
    MatBadgeModule,
    MatSnackBarModule,
    HttpClientModule,
    TranslateModule.forRoot({
      defaultLanguage: 'hu'
    }),
  ],
  providers: [],
  bootstrap: [AppComponent],
})
export class AppModule {}
