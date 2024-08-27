<?php

namespace App\Models\Transaction;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    protected $table = 'transaction';
    protected $guarded = [];
    const STATUS_PROCESS = 1;
    const STATUS_CANCEL = 0;
    const STATUS_ACCEPTED = 2;

    public function transactionItem()
    {
        return $this->hasMany(TransactionItem::class, 'id_transaction', 'id');
    }

    public static function generateInvoiceNumber()
    {
        // Dapatkan tanggal hari ini dalam format YYMMDD
        $date = Carbon::now()->format('ymd');

        // Hitung jumlah transaksi untuk tanggal ini
        $count = self::whereDate('created_at', Carbon::today())->count() + 1;

        // Format nomor invoice
        return sprintf('%s%04d', $date, $count);
    }
}
