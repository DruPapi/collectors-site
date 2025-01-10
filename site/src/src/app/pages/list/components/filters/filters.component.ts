import { Component, EventEmitter, Output } from "@angular/core";

@Component({
  selector: "app-filters",
  templateUrl: "filters.components.html",
})
export class FiltersComponent {
  @Output() showCategory = new EventEmitter<string>();
  categories = ["shoes", "sports"];

  onShowCategory(category: string): void {
    this.showCategory.emit(category);
  }
}
