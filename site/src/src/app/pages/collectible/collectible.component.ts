import { Component, OnInit } from "@angular/core";
import { BaseComponent } from "../base/base.component";
import { CollectibleItem, Collectible } from "../../models/collectible.model";
import { CollectibleService } from "../../services/collectible.service";
import { ErrorHandlerService } from "../../services/error-handler.service";
import { CategoryItem } from "../../models/category.model";
import { ActivatedRoute } from "@angular/router";

@Component({
  selector: "app-cart",
  templateUrl: "collectible.component.html",
  styles: [],
})
export class CollectibleComponent extends BaseComponent implements OnInit {
  id: number = 0;
  categoryId: number | null = null;
  category: CategoryItem | null = null;
  dataSource: Collectible | null = null;
  collectible: CollectibleItem | null = null;

  constructor(
      private collectibleService: CollectibleService,
      private errorHandler: ErrorHandlerService,
      private activatedRoute: ActivatedRoute,
  ) {
    super();
  }

  ngOnInit(): void {
    this.categoryId = this.activatedRoute.snapshot.queryParams['category_id'];

    this.activatedRoute.params.subscribe(params => {
      this.id = params['id'];
      this.collectibleService.getCollectible(this.id, this.categoryId).subscribe({
        next: (data) => {
          this.dataSource = data;
          this.collectible = data.item;
        },
        error: (error) => {
          this.errorHandler.handle(error);
        },
      });
    });
  }

  onShowCategory(newCategory: CategoryItem): void {
    this.category = newCategory;
    console.log(newCategory);
  }
}
