import { Component, HostListener } from "@angular/core";
import { BaseComponent } from "../base/base.component";
import { CollectibleItem, Collectibles } from "../../models/collectible.model";
import { CollectibleService } from "../../services/collectible.service";
import { ErrorHandlerService } from "../../services/error-handler.service";
import { CategoryItem } from "../../models/category.model";
import { ActivatedRoute } from "@angular/router";

@Component({
  selector: "app-cart",
  templateUrl: "collectibles.component.html",
  styles: [],
})
export class CollectiblesComponent extends BaseComponent {
  categoryId: number | null = null;
  page: number = 1;
  category: CategoryItem | null = null;
  collectibles: Collectibles | null = null;
  dataSource: CollectibleItem[] = [];
  cols: number = 4;
  @HostListener('window:resize', ['$event'])
  override handleResize(event: Event) {
    super.handleResize(event);
    this.calculateColumnCount();
  }

  constructor(
      private collectibleService: CollectibleService,
      private errorHandler: ErrorHandlerService,
      private activatedRoute: ActivatedRoute,
  ) {
    super();

    this.calculateColumnCount();
  }

  ngOnInit(): void {
    this.categoryId = this.activatedRoute.snapshot.queryParams['category_id'];
    this.page = this.activatedRoute.snapshot.queryParams['page']  ?? this.page;

    this.collectibleService.getCollectibles(this.categoryId, this.page).subscribe({
      next: (data) => {
        this.collectibles = data;
        this.dataSource = data.items;
      },
      error: (error) => {
        this.errorHandler.handle(error);
      },
    });
  }

  onColumnsCountChange(colsNum: number): void {
    this.cols = colsNum;
    console.log(colsNum);
  }

  onShowCategory(newCategory: CategoryItem): void {
    this.category = newCategory;
    console.log(newCategory);
  }

  private calculateColumnCount(): void {
    this.onColumnsCountChange(Math.ceil(this.screenWidth / 300));
  }
}
