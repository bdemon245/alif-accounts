<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Party;
use App\Models\Company;
use App\Models\Program;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Grid;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\Repeater;
use Filament\Tables\Columns\Layout\Panel;
use Filament\Tables\Columns\Layout\Stack;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\ProgramResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ProgramResource\RelationManagers;
use App\Models\Trailer;
use Closure;

class ProgramResource extends Resource
{
    protected static ?string $model = Program::class;

    protected static ?string $recordTitleAttribute = 'delivery_date';
    protected static ?string $navigationIcon = 'heroicon-o-truck';

    public static function getModelLabel(): string
    {
        return trans('Program');
    }
    public static function getPluralModelLabel(): string
    {
        return trans('Programs');
    }
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make()->columns(4)->schema([
                    Forms\Components\DatePicker::make('delivery_date')
                        ->label(trans("Delivery's") . " " . trans('Date'))
                        ->default(today())
                        ->displayFormat('d/m/Y')
                        ->required(),
                    Forms\Components\TextInput::make('weight')
                        ->label('Weight')
                        ->default(0)
                        ->suffix('kg')
                        ->required(),
                    Forms\Components\TextInput::make('fare')
                        ->label(trans("Rent"))
                        ->default(0)
                        ->suffix(html_entity_decode('&#2547;'))
                        ->required(),
                    Forms\Components\Toggle::make('is_cash')
                        ->label(trans("Cash"))
                        ->default(false)
                        ->inline(false)
                        ->reactive()
                        ->required()
                        ->afterStateUpdated(
                            function ($state, callable $set) {
                                if ($state) {
                                    $set('job_no', null);
                                } else {
                                    $set('job_no', 'hidden');
                                }
                            }
                        ),
                ]),
                Forms\Components\Grid::make()
                    ->columns(3)
                    ->schema([
                        Forms\Components\Select::make('party_id')
                            ->label('Party')
                            ->default(1)
                            ->relationship('party', 'name')
                            ->options(Party::all()->pluck('name', 'id'))
                            ->required()
                            ->reactive()
                            ->createOptionForm([
                                Forms\Components\TextInput::make('name')
                                    ->label(trans("Party's") . " " . trans('Name'))
                                    ->required(),
                            ]),
                        Forms\Components\Select::make('factory_id')
                            ->label('Factory')
                            ->default(1)
                            ->relationship('factory', 'name')
                            ->options(function (callable $get) {
                                $id = $get('party_id');
                                if ($id > 0) {
                                    # code...
                                    $trailers = Party::find($id)->factories;
                                    return $trailers->pluck('name', 'id');
                                }
                                return [];
                            })
                            ->required()
                            ->createOptionForm([
                                Forms\Components\TextInput::make('name')
                                    ->label(trans("Factory's") . " " . trans('Name'))
                                    ->required(),
                            ]),


                        Forms\Components\TextInput::make('job_no')
                            ->hidden(fn (Closure $get): bool => $get('is_cash') == false)
                            ->requiredWith('is_cash')
                            ->label(trans("Job") . " " . trans('No.')),
                    ]),
                Repeater::make('trips')
                    ->hidden(fn (Closure $get): bool => $get('is_cash') == true)
                    ->relationship()
                    ->columns(8)
                    ->schema([
                        Forms\Components\Select::make('company_id')
                            ->label(trans('Company'))
                            ->options(Company::all()->pluck('name', 'id'))
                            ->reactive()
                            ->searchable()
                            ->afterStateUpdated(fn (callable $set) => $set('trailer_no', null))
                            ->createOptionForm([
                                Forms\Components\TextInput::make('company')
                                    ->label(trans("New") . " " . trans('Company'))
                                    ->autofocus(true)
                                    ->required(),
                            ])
                            ->columnSpan([
                                'default' => 8,
                                'lg' => 2
                            ]),
                        Forms\Components\Select::make('trailer_no')
                            ->label(trans('Trailer\'s') . " " . trans('Number'))
                            ->searchable()
                            ->multiple()
                            ->options(function (callable $get) {
                                $id = $get('company_id');
                                if ($id > 0) {
                                    # code...
                                    $trailers = Company::find($id)->trailers;
                                    return $trailers->pluck('number', 'number');
                                }
                                return [];
                            })
                            // ->createOptionForm([
                            //     Forms\Components\TextInput::make('number')
                            //         ->label(trans("New") . " " . trans('Trailer'))
                            //         ->autofocus(true)
                            //         ->required(),
                            // ])
                            ->columnSpan([
                                'default' => 8,
                                'lg' => 3
                            ]),

                        Forms\Components\TextInput::make('chalan')
                            ->reactive()
                            ->label(trans('Main') . " " . trans('Fare'))
                            ->afterStateUpdated(function ($state, callable $get, callable $set) {
                                $set('due', $state - $get('advance'));
                            })
                            ->numeric()
                            ->placeholder(trans('Main') . " " . trans('Fare'))
                            ->suffix(html_entity_decode('&#2547;'))
                            ->default(0)
                            ->columnSpan([
                                'default' => 8,
                                'sm' => 4,
                                'lg' => 1,
                            ]),
                        Forms\Components\TextInput::make('advance')
                            ->reactive()
                            ->afterStateUpdated(fn ($state, callable $get, callable $set) => $set('due', $get('chalan') - $state))
                            ->numeric()
                            ->placeholder(trans('Advance'))
                            ->suffix(html_entity_decode('&#2547;'))
                            ->default(0)
                            ->columnSpan([
                                'default' => 8,
                                'sm' => 4,
                                'lg' => 1,
                            ]),
                        Forms\Components\TextInput::make('due')
                            ->numeric()
                            ->placeholder(trans('Due'))
                            ->suffix(html_entity_decode('&#2547;'))
                            ->default(0)
                            ->columnSpan([
                                'default' => 8,
                                'sm' => 8,
                                'lg' => 1,
                            ]),
                    ]),
                Repeater::make('trips')
                    ->hidden(fn (Closure $get): bool => $get('is_cash') == false)
                    ->relationship()
                    ->columns(8)
                    ->schema([
                        Forms\Components\Select::make('company_id')
                            ->label(trans('Company'))
                            ->options(Company::all()->pluck('name', 'id'))
                            ->reactive()
                            ->searchable()
                            ->afterStateUpdated(fn (callable $set) => $set('trailer_no', null))
                            ->createOptionForm([
                                Forms\Components\TextInput::make('company')
                                    ->label(trans("New") . " " . trans('Company'))
                                    ->autofocus(true)
                                    ->required(),
                            ])
                            ->columnSpan([
                                'default' => 8,
                                'lg' => 2
                            ]),
                        Forms\Components\Select::make('trailer_no')
                            ->label(trans('Trailer\'s') . " " . trans('Number'))
                            ->searchable()
                            ->multiple()
                            ->options(function (callable $get) {
                                $id = $get('company_id');
                                if ($id > 0) {
                                    # code...
                                    $trailers = Company::find($id)->trailers;
                                    return $trailers->pluck('number', 'number');
                                }
                                return [];
                            })
                            ->createOptionForm([
                                Forms\Components\TextInput::make('number')
                                    ->label(trans("New") . " " . trans('Trailer'))
                                    ->autofocus(true)
                                    ->required(),
                            ])
                            ->columnSpan([
                                'default' => 8,
                                'lg' => 3
                            ]),

                        Forms\Components\TextInput::make('chalan')
                            ->reactive()

                            ->afterStateUpdated(function ($state, callable $get, callable $set) {
                                $set('due', $state - $get('rent'));
                            })
                            ->numeric()
                            ->suffix(html_entity_decode('&#2547;'))
                            ->default(0)
                            ->columnSpan([
                                'default' => 8,
                                'sm' => 4,
                                'lg' => 1,
                            ]),

                        Forms\Components\TextInput::make('rent')
                            ->label(trans('Company\'s') . ' ' . trans('Fare'))
                            ->reactive()
                            ->afterStateUpdated(fn ($state, callable $get, callable $set) => $set('commission', $get('chalan') - $state))
                            ->numeric()
                            ->placeholder(trans('Rent'))
                            ->suffix(html_entity_decode('&#2547;'))
                            ->default(0)
                            ->columnSpan([
                                'default' => 8,
                                'sm' => 4,
                                'lg' => 1,
                            ]),
                        Forms\Components\TextInput::make('commission')
                            ->numeric()
                            ->placeholder(trans('Commission'))
                            ->suffix(html_entity_decode('&#2547;'))
                            ->default(0)
                            ->columnSpan([
                                'default' => 8,
                                'sm' => 8,
                                'lg' => 1,
                            ]),

                    ]),

            ])->columns(1);
    }

    protected function getTableFiltersFormColumns(): int
    {
        return 3;
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('delivery_date')
                    ->searchable()
                    ->label(trans('Delivery\'s') . ' ' . trans('Date'))
                    ->date('d / m / Y'),
                Tables\Columns\ViewColumn::make('id')
                    ->label(__('Program\'s') . ' ' . __('Details'))
                    ->view('filament.tables.columns.program-details'),
                Tables\Columns\ViewColumn::make('trips')
                    ->label(trans('Trip\'s') . " " . trans('Details'))
                    ->extraAttributes(['class' => 'bg-rose-500'])
                    ->view('filament.tables.columns.trip-list'),

            ])
            ->filters([
                Filter::make('is_cash')
                    ->label(trans('Cash'))
                    // ->indicator(trans('Cash'))
                    ->query(fn (Builder $query): Builder => $query->orWhere('is_cash', true)),
                Filter::make('is_due')
                    ->label(trans('Due'))
                    // ->indicator(trans('Due'))
                    ->query(fn (Builder $query): Builder => $query->orWhere('is_cash', false)),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPrograms::route('/'),
            'create' => Pages\CreateProgram::route('/create'),
            'view' => Pages\ViewProgram::route('/{record}'),
            'edit' => Pages\EditProgram::route('/{record}/edit'),
        ];
    }
}
