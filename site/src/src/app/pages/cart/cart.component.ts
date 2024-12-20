import { Component } from "@angular/core";
import { Cart, CartItem } from "src/app/models/cart.model";

@Component({
  selector: "app-cart",
  templateUrl: "cart.component.html",
  styles: [],
})
export class CartComponent {
  cart: Cart = {
    items: [
      {
        product: "https://via.placeholder.com/150",
        name: "Snickers",
        price: 100,
        quantity: 1,
        id: 1,
      },
      {
        product: "https://via.placeholder.com/150",
        name: "Mars",
        price: 200,
        quantity: 2,
        id: 2,
      },
    ],
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
    return items.reduce((acc, curr) => acc + curr.price * curr.quantity, 0);
  }
}
