import { Injectable } from '@angular/core';
import {HttpClient, HttpParams} from "@angular/common/http";
import { Observable } from "rxjs";
import { Collectible, Collectibles } from "../models/collectible.model";

@Injectable({
  providedIn: 'root'
})
export class CollectibleService {

  constructor(private http: HttpClient) {}

  getCollectibles(categoryId: number | null, page: number | 1): Observable<Collectibles> {
    let params = new HttpParams();

    params = params.set('page', page);
    if (categoryId) {
      params = params.set('category_id', categoryId);
    }

    return this.http.get<Collectibles>('/api/collectibles', {
      params: params
    });
  }

  getCollectible(id: number, categoryId: number | null): Observable<Collectible> {
    console.log('loading collectible', id, categoryId);

    let params = new HttpParams();

    if (categoryId) {
      params = params.set('category_id', categoryId);
    }

    return this.http.get<Collectible>(`/api/collectibles/${id}`, {
      params: params
    })
  }
}
