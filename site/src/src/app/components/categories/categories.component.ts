import { Component, EventEmitter, Output } from "@angular/core";
import { Categories, CategoryItem } from "../../models/category.model";
import { CategoryService } from "../../services/category.service";
import { ErrorHandlerService } from "../../services/error-handler.service";

@Component({
  selector: "app-categories",
  templateUrl: "categories.component.html",
})
export class CategoriesComponent {
  @Output() showCategory = new EventEmitter<CategoryItem>();
  categories:Categories | undefined;
  dataSource: Array<CategoryItem> = [];

  constructor(
      private errorHandler: ErrorHandlerService,
      private categoryService: CategoryService,
  ) {}

  onShowCategory(category: CategoryItem): void {
    this.showCategory.emit(category);
  }

  ngOnInit(): void {
    this.categoryService.getCategories().subscribe({
      next: (data) => {
        this.categories = data;
        this.dataSource = this.categories.items;
      },
      error: (error) => {
        this.errorHandler.handle(error);
      },
    });
  }
}
