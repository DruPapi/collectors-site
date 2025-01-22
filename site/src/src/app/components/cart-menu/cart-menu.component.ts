import { Component } from "@angular/core";
import { CartService } from "../../services/cart.service";
import { CartItem } from "../../models/cart.model";

@Component({
    selector: "app-cart-menu",
    templateUrl: "cart-menu.component.html",
})
export class CartMenuComponent {
    constructor(
        private cartService: CartService,
    ) {}

    getCartItems(): Array<CartItem> {
        return this.cartService.cartItems;
    }
}
