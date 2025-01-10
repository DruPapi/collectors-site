import { Injectable } from '@angular/core';
import { HttpClient } from "@angular/common/http";
import { Categories } from "../models/category.model";
import { Observable } from "rxjs";

@Injectable({
  providedIn: 'root'
})
export class CategoryService {

  constructor(private http: HttpClient) {}

  getCategories(): Observable<Categories> {
    return this.http.get<Categories>('/api/categories');
  }
}
