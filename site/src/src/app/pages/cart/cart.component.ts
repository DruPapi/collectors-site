import { Component } from "@angular/core";
import { Cart, CartItem } from "src/app/models/cart.model";

@Component({
  selector: "app-cart",
  templateUrl: "cart.component.html",
  styles: [],
})
export class CartComponent {
  cart: Cart = {
    items: [],
  };
  dataSource: CartItem[] = [];
  displayedColumns: string[] = [
    "product",
    "name",
    "price",
    "quantity",
    "total",
    "action"
  ];
  ngOnInit(): void {
    this.dataSource = this.cart.items;
  }
  getTotal(items: CartItem[]): number {
    return items.reduce((acc, curr) => acc + curr.collectible.value * curr.quantity, 0);
  }
}
