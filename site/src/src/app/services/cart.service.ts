import { Injectable } from '@angular/core';
import { HttpClient, HttpParams } from "@angular/common/http";
import { Observable } from "rxjs";
import { Cart, CartItem } from "../models/cart.model";
import { CollectibleItem } from "../models/collectible.model";

@Injectable({
  providedIn: 'root'
})
export class CartService {
  public cartItems: Array<CartItem> = [];

  constructor(private http: HttpClient) {
    this.http.get<Cart>('/api/cart').subscribe({
      next: (data: Cart) => {
        this.cartItems = data.items;
      }
    });
  }

  addToCart(item: CollectibleItem | null): Observable<CartItem> {
    let postData = {
      collectible_id: item?.id,
      quantity: 1,
    };

    let request = this.http.post<CartItem>('/api/cart/add', postData);
    request.subscribe({
      next: (data: CartItem) => {
        this.cartItems.push(data);
      }
    });

    return request;
  }

  removeFromCart(item: CollectibleItem | null): any {
    let params = new HttpParams();

    if (item?.id) {
      params = params.set("collectible_id", item?.id);
    }

    let request = this.http.delete(`/api/cart/remove`, {
      params: params
    });
    request.subscribe({
      next: () => {
        this.cartItems = this.cartItems.filter((cartItem) => item?.id != cartItem.collectible.id);
      }
    })

    return request;
  }
}
