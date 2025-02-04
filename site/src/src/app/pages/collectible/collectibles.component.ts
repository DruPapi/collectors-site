import { Component, HostListener } from "@angular/core";
import { BaseComponent } from "../base/base.component";
import { CollectibleItem, Collectibles } from "../../models/collectible.model";
import { CollectibleService } from "../../services/collectible.service";
import { ErrorHandlerService } from "../../services/error-handler.service";
import { Categories, CategoryItem } from "../../models/category.model";
import { ActivatedRoute } from "@angular/router";
import { CategoryService } from "../../services/category.service";
import { PathService } from "../../services/path.service";

@Component({
  selector: "app-cart",
  templateUrl: "collectibles.component.html",
  styleUrls: ["collectibles.component.scss"],
})
export class CollectiblesComponent extends BaseComponent {
  categoryId: number | null = null;
  page: number = 1;
  category: CategoryItem | null = null;
  categoryPath: CategoryItem[] = [];
  collectibles: Collectibles | null = null;
  dataSource: CollectibleItem[] = [];
  cols: number = 4;
  @HostListener('window:resize', ['$event'])
  override handleResize(event: Event) {
    super.handleResize(event);
    this.calculateColumnCount();
  }

  constructor(
      public path: PathService,
      private collectibleService: CollectibleService,
      private categoryService: CategoryService,
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

    this.categoryService.getCategories().subscribe({
      next: (data: Categories): void => {
        this.categoryPath = [];
        let found = data.items.find((it: CategoryItem) => it.id == this.categoryId);
        if (found) {
          this.categoryPath.push(found);
        }
      }
    });
  }

  onColumnsCountChange(colsNum: number): void {
    this.cols = colsNum;
  }

  onShowCategory(newCategory: CategoryItem): void {
    this.category = newCategory;
    console.log(newCategory);
  }

  private calculateColumnCount(): void {
    this.onColumnsCountChange(Math.ceil(this.screenWidth / 300));
  }
}
