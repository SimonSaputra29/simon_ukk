import { test } from 'node:test';
import assert from 'node:assert';
import { sum } from './index.js';

// Pengujian fungsi sum
test('Fungsi sum menambahkan dua angka dengan benar', () => {
  // Pengujian untuk angka positif
  assert.strictEqual(sum(2, 3), 5, 'Sum(2, 3) seharusnya menghasilkan 5');

  // Pengujian untuk angka negatif
  assert.strictEqual(sum(-2, -3), -5, 'Sum(-2, -3) seharusnya menghasilkan -5');

  // Pengujian untuk angka campuran
  assert.strictEqual(sum(2, -3), -1, 'Sum(2, -3) seharusnya menghasilkan -1');

  // Pengujian dengan nol
  assert.strictEqual(sum(0, 0), 0, 'Sum(0, 0) seharusnya menghasilkan 0');
});
