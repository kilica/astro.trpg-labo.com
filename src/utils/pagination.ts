export type PaginationItem = number | 'ellipsis';

export interface PaginationOptions {
  currentPage: number;
  totalPages: number;
  siblingCount?: number;
  boundaryCount?: number;
}

export function getPaginationItems({
  currentPage,
  totalPages,
  siblingCount = 2,
  boundaryCount = 1,
}: PaginationOptions): PaginationItem[] {
  // If total pages is small enough, show all pages
  const totalNumbers = boundaryCount * 2 + siblingCount * 2 + 3; // boundaries + siblings + current + 2 ellipses
  if (totalPages <= totalNumbers) {
    return Array.from({ length: totalPages }, (_, i) => i + 1);
  }

  const leftSiblingIndex = Math.max(currentPage - siblingCount, boundaryCount + 1);
  const rightSiblingIndex = Math.min(currentPage + siblingCount, totalPages - boundaryCount);

  const showLeftEllipsis = leftSiblingIndex > boundaryCount + 2;
  const showRightEllipsis = rightSiblingIndex < totalPages - boundaryCount - 1;

  const items: PaginationItem[] = [];

  // Add left boundary pages
  for (let i = 1; i <= boundaryCount; i++) {
    items.push(i);
  }

  // Add left ellipsis or fill gap
  if (showLeftEllipsis) {
    items.push('ellipsis');
  } else {
    // Fill the gap between boundary and left sibling
    for (let i = boundaryCount + 1; i < leftSiblingIndex; i++) {
      items.push(i);
    }
  }

  // Add sibling pages and current page
  for (let i = leftSiblingIndex; i <= rightSiblingIndex; i++) {
    items.push(i);
  }

  // Add right ellipsis or fill gap
  if (showRightEllipsis) {
    items.push('ellipsis');
  } else {
    // Fill the gap between right sibling and boundary
    for (let i = rightSiblingIndex + 1; i <= totalPages - boundaryCount; i++) {
      items.push(i);
    }
  }

  // Add right boundary pages
  for (let i = totalPages - boundaryCount + 1; i <= totalPages; i++) {
    items.push(i);
  }

  return items;
}
