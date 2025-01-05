<?php

namespace App\Filament\Filters;

use Filament\Forms;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;

class DateFilter
{
    private string $column;

    public function __construct(string $column) {
        $this->column = $column;
    }

    public static function make(string $column) {
        return new self($column);
    }

    public function exact(string $name): Filter
    {
        $name ??= $this->column;

        return Filter::make($this->column)
            ->form([
                Forms\Components\DatePicker::make($name),
            ])
            ->query(function (Builder $query, array $data) use ($name): Builder {
                return $query
                    ->when(
                        $data[$name],
                        fn (Builder $query, $date): Builder => $query->whereDate($this->column, $date),
                    );
            });
    }

    public function range(string $from = null, string $to = null): Filter
    {
        $from ??= $this->column.'_from';
        $to ??= $this->column.'_to';

        return Filter::make($this->column)
            ->form([
                Forms\Components\DatePicker::make($from),
                Forms\Components\DatePicker::make($to)->default(now()),
            ])
            ->query(function (Builder $query, array $data) use ($from, $to): Builder {
                return $query
                    ->when(
                        $data[$from],
                        fn (Builder $query, $date): Builder => $query->whereDate($this->column, '>=', $date),
                    )
                    ->when(
                        $data[$to],
                        fn (Builder $query, $date): Builder => $query->whereDate($this->column, '<=', $date),
                    );
            });
    }
}
