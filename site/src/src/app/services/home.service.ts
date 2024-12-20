import { Injectable } from '@angular/core';
import { HttpClient } from "@angular/common/http";
import { Observable } from "rxjs";
import { HomeContent } from "../models/home-content.model";

@Injectable({
  providedIn: 'root'
})
export class HomeService {

  constructor(private http: HttpClient) {}

  getContents(): Observable<HomeContent> {
    return this.http.get<HomeContent>('/api/home');
  }
}
