<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReservationResource\Pages;
use App\Filament\Resources\ReservationResource\RelationManagers;
use App\Models\Reservation;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;
use pxlrbt\FilamentExcel\Exports\ExcelExport;

class ReservationResource extends Resource
{
    protected static ?string $model = Reservation::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar';

    protected static ?string $navigationLabel = 'Reservaciones';

    protected static ?string $modelLabel = 'Reservaciones';

    protected static ?string $navigationBadgeTooltip = 'Total de reservaciones';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->orderBy('id', 'desc');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Información de la Reserva')
                    ->columns(2)
                    ->icon('heroicon-o-information-circle')
                    ->schema([
                        Forms\Components\Select::make('user_id')
                            ->relationship(name: 'user', titleAttribute: 'name')
                            ->label('Nombre del usuario')
                            ->preload()
                            ->required(),
                        Forms\Components\Select::make('room_id')
                            ->relationship(
                                'room',
                                'name',
                                fn($query) => $query->where('status', 'activa') // Filtra solo las salas activas
                            )
                            ->preload()
                            ->label('Nombre de la sala')
                            ->required(),
                        Forms\Components\Select::make('distribution_id')
                            ->relationship(name: 'distribution', titleAttribute: 'name')
                            ->label('Distribución de sillas')
                            ->preload()
                            ->required(),
                    ]),
                Section::make('Fechas de inicio y fin')
                    ->columns(2)
                    ->icon('heroicon-o-calendar-days')
                    ->schema([
                        Forms\Components\DatePicker::make('start_date')
                            ->required(),
                        Forms\Components\DatePicker::make('end_date')
                            ->required(),
                        Forms\Components\Select::make('status')
                            ->options([
                                'aceptada' => 'Aceptada',
                                'pendiente' => 'Pendiente',
                                'rechazada' => 'Rechazada',
                            ])
                            ->required()
                            ->visibleOn('edit'),
                    ]),
                Section::make('Notas extras')
                    ->columns(1)
                    ->icon('heroicon-o-pencil')
                    ->schema([
                        Forms\Components\Textarea::make('notes')
                            ->label('Notas extras')
                            ->placeholder('Escribe aquí alguna nota extra...')
                            ->columnSpanFull(),
                        Forms\Components\Textarea::make('answer')
                            ->columnSpanFull()
                            ->visibleOn('edit'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Nombre del usuario')
                    ->numeric()
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('room.name')
                    ->label('Nombre de la sala')
                    ->numeric()
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('distribution.name')
                    ->label('Distribución de sillas')
                    ->numeric()
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('start_date')
                    ->label('Fecha de inicio')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('end_date')
                    ->label('Fecha de fin')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Estado')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'aceptada' => 'success',
                        'rechazada' => 'danger',
                        'pendiente' => 'warning',
                    })
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'aceptada' => 'Aceptada',
                        'pendiente' => 'Pendiente',
                        'rechazada' => 'Rechazada',
                    ])
                    ->label('Estado de la reservación'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    ExportBulkAction::make()
                        ->exports([
                            ExcelExport::make('class')->fromTable()
                                ->withFilename('Reservaciones_' . date('d-m-Y') . '_export')
                                ->label('Exportar en formato de tabla')
                                ->askForFilename(label: 'Nombre del archivo')
                                ->askForWriterType(label: 'Formato de archivo'),
                            ExcelExport::make('form')->fromForm()
                                ->withFilename('Reservaciones_' . date('d-m-Y') . '_export')
                                ->label('Exportar en formato de formulario')
                                ->askForFilename(label: 'Nombre del archivo')
                                ->askForWriterType(label: 'Formato de archivo'),
                        ]),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListReservations::route('/'),
            'create' => Pages\CreateReservation::route('/create'),
            'edit' => Pages\EditReservation::route('/{record}/edit'),
        ];
    }
}
