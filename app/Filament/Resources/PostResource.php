<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PostResource\Pages;
use App\Filament\Resources\PostResource\RelationManagers;
use App\Filament\Resources\PostResource\RelationManagers\AuthorsRelationManager;
use App\Models\Category;
use App\Models\Post;
use Filament\Forms;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Field;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\CheckboxColumn;
use Filament\Tables\Columns\ColorColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Nette\Utils\ImageColor;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static ?string $navigationIcon = 'heroicon-o-photo';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Content')
                        ->description('add post\'s content here')
                        ->collapsible()
                        ->schema([
                            TextInput::make('title')->required(),
                            TextInput::make('slug')->required(),
                            Select::make('category_id')
                                  ->label('Category')
                                  ->relationship('category', 'name')
                                  ->searchable()
                                  //->options(Category::orderBy('name', 'asc')->pluck('name', 'id'))
                                  ->required(),
                            ColorPicker::make('color')->required(),
                            MarkdownEditor::make('content')->required()
                        ])
                ->columnSpan(1),
                Group::make()
                    ->schema([
                        Section::make('Image')
                        ->schema([
                            FileUpload::make('thumbnail')->disk('public')->directory('thumbnails')
                        ])
                        ->columnSpan(1),
                        Section::make('Meta')
                        ->schema([
                            TagsInput::make('tags')->required(),
                            Checkbox::make('published')
                        ])
                        ->columnSpan(1),
                        /*
                        Section::make('Author')
                        ->schema([
                            Select::make('authors')
                                  ->searchable(condition:false)
                                  ->multiple()
                                  ->relationship('authors', 'name')
                        ])
                        ->columnSpan(1),
                        */
                    ])
            ])
            ->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                          ->sortable()
                          ->toggleable(isToggledHiddenByDefault:true),
                TextColumn::make('title')
                          ->sortable()
                          ->searchable()
                          ->toggleable(),
                TextColumn::make('slug')
                          ->sortable()
                          ->searchable()
                          ->toggleable(),
                TextColumn::make('category.name')
                          ->sortable()
                          ->searchable()
                          ->toggleable(),
                ColorColumn::make('color')
                           ->toggleable(),
                ImageColumn::make('thumbnail')
                           ->toggleable(),
                TextColumn::make('tags')
                          ->toggleable(),
                CheckboxColumn::make('published')
                              ->sortable()
                              ->searchable()
                              ->toggleable(),
                TextColumn::make('created_at')
                          ->label('Published On')
                          ->date()
                          ->sortable()
                          ->searchable()
                          ->toggleable(),                        
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            AuthorsRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
        ];
    }
}
