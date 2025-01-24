import { Component, Input } from '@angular/core';
import { CollectibleItem } from "../../models/collectible.model";
import { PathService } from "../../services/path.service";

@Component({
  selector: 'app-product-box',
  templateUrl: './product-box.component.html',
  styleUrls: ['./product-box.component.scss'],
})
export class ProductBoxComponent {
@Input() fullWidthMode = false;
@Input() collectible: CollectibleItem | null = null;
@Input() categoryId: number | null = null;

  constructor(
      public path: PathService,
  ) {}

}
