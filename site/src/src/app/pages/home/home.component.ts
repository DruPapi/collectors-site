import { Component } from "@angular/core";
const ROWS_HEIGHT: { [id: number]: number } = { 1: 400, 3: 335, 4: 350 };
@Component({
  selector: "app-home",
  templateUrl: "./home.component.html",
})
export class HomeComponent {
  cols = 3;
  rowHeight = ROWS_HEIGHT[this.cols];
  category: string | undefined;

  onColumnsCountChange(colsNum: number): void {
    this.cols = colsNum;
    console.log(colsNum); //*working out
  }
  onShowCategory(newCategory: string): void {
    this.category = newCategory;
    console.log(newCategory);
  }
}
