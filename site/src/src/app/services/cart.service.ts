import { Injectable } from '@angular/core';
import { HttpClient, HttpParams } from "@angular/common/http";
import { Observable, tap } from "rxjs";
import { Cart, CartI, CartItem } from "../models/cart.model";
import { CollectibleItem } from "../models/collectible.model";

@Injectable({
  providedIn: 'root'
})
export class CartService {
  public cart: CartI = new Cart([]);

  constructor(private http: HttpClient) {
    this.load();
  }

  load(): void {
    this.http.get<CartI>('/api/cart').subscribe({
      next: (data: Cart) => {
        this.cart = new Cart(data.items);
      }
    });
  }

  addToCart(item: CollectibleItem | null): Observable<CartItem> {
    let postData = {
      collectible_id: item?.id,
      quantity: 1,
    };

    return this.http.post<CartItem>('/api/cart/add', postData).pipe(
        tap(cartItem => {
            this.cart.items.push(cartItem);
        })
    );
  }

  removeFromCart(item: CollectibleItem | null): any {
    let params = new HttpParams();

    if (item?.id) {
      params = params.set("collectible_id", item?.id);
    }

    return this.http.delete(`/api/cart/remove`, {
      params: params
    }).pipe(
        tap(_ => {
            this.cart.items = this.cart.items.filter((cartItem) => item?.id != cartItem.collectible.id);
        })
    );
  }
}
