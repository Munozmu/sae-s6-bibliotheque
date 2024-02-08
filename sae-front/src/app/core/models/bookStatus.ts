export interface BookStatus {
  avalaible: boolean;
  borrowed: boolean;
  reserved: boolean;
  reservedByUser: boolean;
  borrowedByUser: boolean;
  reservationId?: number;
}
