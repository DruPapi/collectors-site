import { Injectable } from '@angular/core';
import { HttpClient } from "@angular/common/http";
import { Categories } from "../models/category.model";
import { Observable } from "rxjs";

@Injectable({
  providedIn: 'root'
})
export class CategoryService {
  private categories: Observable<Categories>;

  constructor(private http: HttpClient) {
    this.categories = this.loadCategories();
  }

  getCategories(): Observable<Categories> {
    return this.categories;
  }

  private loadCategories(): Observable<Categories> {
    return this.http.get<Categories>('/api/categories');
  }
}
