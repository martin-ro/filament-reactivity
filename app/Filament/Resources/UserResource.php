<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Builder::make('blocks')
                    ->blockPreviews()
                    ->schema([

                        // This will lose reactivity
                        Forms\Components\Builder\Block::make('test')
                            ->preview('filament.block-previews.test')
                            ->schema([
                               Forms\Components\Checkbox::make('isCompany')
                                    ->live(),

                                Forms\Components\TextInput::make('name')
                                    ->hidden(fn(Forms\Get $get) => !$get('isCompany')),
                            ]),

                        // This will work because it's wrapped in a group
//                        Forms\Components\Builder\Block::make('test')
//                            ->preview('filament.block-previews.test')
//                            ->schema([
//                                Forms\Components\Group::make()
//                                    ->schema([
//                                        Forms\Components\Checkbox::make('isCompany')
//                                            ->live(),
//
//                                        Forms\Components\TextInput::make('name')
//                                            ->hidden(fn(Forms\Get $get) => !$get('isCompany')),
//                                    ]),
//                            ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
