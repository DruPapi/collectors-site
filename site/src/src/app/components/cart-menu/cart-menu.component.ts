import { Component } from "@angular/core";
import { CartService } from "../../services/cart.service";
import { CartI, CartItem } from "../../models/cart.model";

@Component({
    selector: "app-cart-menu",
    templateUrl: "cart-menu.component.html",
})
export class CartMenuComponent {
    constructor(
        private cartService: CartService,
    ) {}

    getCart(): CartI {
        return this.cartService.cart;
    }

    getCartItems(): Array<CartItem> {
        return this.getCart().items;
    }
}
