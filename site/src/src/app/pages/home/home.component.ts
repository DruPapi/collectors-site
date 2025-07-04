import { Component } from "@angular/core";
import { BaseComponent } from "../base/base.component";
import { CategoryItem } from "../../models/category.model";
import { HomeService } from "../../services/home.service";
import { HomeContent } from "../../models/home-content.model";
import { ErrorHandlerService } from "../../services/error-handler.service";

@Component({
  selector: "app-home",
  templateUrl: "./home.component.html",
})
export class HomeComponent extends BaseComponent {
  category: CategoryItem | undefined;
  dataSource: HomeContent | undefined;

  constructor(
      private homeService: HomeService,
      private errorHandler: ErrorHandlerService,
  ) {
    super();
  }

  ngOnInit(): void {
    console.log("HomeComponent");
    this.homeService.getContents().subscribe({
      next: (data) => {
        this.dataSource = data;
      },
      error: (error) => {
        this.errorHandler.handle(error);
      },
    });
  }

  onShowCategory(newCategory: CategoryItem): void {
    this.category = newCategory;
    console.log(newCategory);
  }
}
