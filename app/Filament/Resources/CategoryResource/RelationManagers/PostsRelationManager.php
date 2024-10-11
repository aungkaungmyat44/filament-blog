<?php

namespace App\Filament\Resources\CategoryResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\CheckboxColumn;
use Filament\Tables\Columns\ColorColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PostsRelationManager extends RelationManager
{
    protected static string $relationship = 'posts';

    public function form(Form $form): Form
    {
        return $form
        ->schema([
            Section::make('Content')
                    ->description('add post\'s content here')
                    ->collapsible()
                    ->schema([
                        TextInput::make('title')->required(),
                        TextInput::make('slug')->required(),
                        ColorPicker::make('color')->required(),
                        MarkdownEditor::make('content')->required()
                    ])
            ->columnSpan(1),
            Group::make()
                ->schema([
                    Section::make('Meta')
                        ->schema([
                            FileUpload::make('thumbnail')->disk('public')->directory('thumbnails')
                        ])
                        ->columnSpan(1),
                    TagsInput::make('tags')->required(),
                    Checkbox::make('published')
                ])
        ])
        ->columns(2);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('Post')
            ->columns([
                TextColumn::make('id')
                          ->sortable()
                          ->toggleable(isToggledHiddenByDefault:true),
                TextColumn::make('title')
                          ->sortable()
                          ->searchable()
                          ->toggleable(),
                ColorColumn::make('color')
                           ->toggleable(),
                ImageColumn::make('thumbnail')
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
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                //
            ])
            ->bulkActions([
                //
            ]);
    }
}
