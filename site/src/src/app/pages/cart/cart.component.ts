import { Component } from "@angular/core";
import { CartI, Cart, CartItem } from "src/app/models/cart.model";

@Component({
  selector: "app-cart",
  templateUrl: "cart.component.html",
  styles: [],
})
export class CartComponent {
  public cart: CartI = new Cart([]);
  public dataSource: CartItem[] = [];
  public displayedColumns: string[] = [
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
}
