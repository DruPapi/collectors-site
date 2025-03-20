import { Injectable } from '@angular/core';
import { HttpClient } from "@angular/common/http";
import { Categories } from "../models/category.model";
import { Observable, shareReplay } from "rxjs";

@Injectable({
  providedIn: 'root'
})
export class CategoryService {
  private request$!: Observable<any>;

  constructor(private http: HttpClient) {}

  getCategories(): Observable<Categories> {
    if (!this.request$) {
      this.request$ = this.http.get<Categories>('/api/categories').pipe(
          shareReplay(1)
      );
    }

    return this.request$;
  }
}
