<?php

namespace Database\Seeders;

use App\Models\Recipe;
use App\Models\Category;
use App\Models\Ingredient;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class IngredientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csv = 'salt,staple,grams
black pepper,staple,grams
white pepper,staple,grams
olive oil,staple,millilitres
vegetable oil,staple,millilitres
sunflower oil,staple,millilitres
rapeseed oil,staple,millilitres
plain flour,staple,grams
self-raising flour,staple,grams
bread flour,staple,grams
caster sugar,staple,grams
granulated sugar,staple,grams
brown sugar,staple,grams
icing sugar,staple,grams
eggs,staple,pieces
milk,staple,millilitres
butter,staple,grams
water,staple,millilitres
garlic,staple,pieces
red onion,staple,pieces
white onion,staple,pieces
shallot,staple,pieces

potatoes,staple,grams
new potatoes,staple,grams
sweet potatoes,staple,grams

basmati rice,staple,grams
long grain rice,staple,grams
short grain rice,staple,grams
brown rice,cupboard_staple,grams
jasmine rice,cupboard_staple,grams


fusilli pasta,staple,grams
rigatoni pasta,staple,grams
ziti pasta,staple,grams
fettuccine pasta,staple,grams
bucatini pasta,staple,grams
macaroni pasta,staple,grams
penne pasta,staple,grams
tagliatelle pasta,staple,grams

baking powder,staple,teaspoons
bicarbonate of soda,staple,teaspoons
vinegar,staple,millilitres
lemon,staple,pieces

tinned tomatoes,cupboard_staple,tins
passata,cupboard_staple,grams
tomato puree,cupboard_staple,tablespoons
chicken stock cube,cupboard_staple,pieces
vegetable stock cube,cupboard_staple,pieces
beef stock cube,cupboard_staple,pieces
fish stock cube,cupboard_staple,pieces
soy sauce,cupboard_staple,millilitres
worcestershire sauce,cupboard_staple,millilitres
fish sauce,cupboard_staple,millilitres
oyster sauce,cupboard_staple,millilitres
ketchup,cupboard_staple,millilitres
mayonnaise,cupboard_staple,millilitres
mustard,cupboard_staple,teaspoons
dijon mustard,cupboard_staple,teaspoons
wholegrain mustard,cupboard_staple,teaspoons
honey,cupboard_staple,grams
golden syrup,cupboard_staple,grams
maple syrup,cupboard_staple,millilitres
jam,cupboard_staple,grams
peanut butter,cupboard_staple,grams
breadcrumbs,cupboard_staple,grams
panko breadcrumbs,cupboard_staple,grams
cornflour,cupboard_staple,grams
cocoa powder,cupboard_staple,grams
vanilla extract,cupboard_staple,teaspoons
yeast,cupboard_staple,sachets
oats,cupboard_staple,grams
couscous,cupboard_staple,grams
quinoa,cupboard_staple,grams
bulgur wheat,cupboard_staple,grams
lentils,cupboard_staple,grams
red lentils,cupboard_staple,grams
green lentils,cupboard_staple,grams
chickpeas,cupboard_staple,tins
kidney beans,cupboard_staple,tins
black beans,cupboard_staple,tins
cannellini beans,cupboard_staple,tins
butter beans,cupboard_staple,tins
baked beans,cupboard_staple,tins
coconut milk,cupboard_staple,tins
evaporated milk,cupboard_staple,tins
condensed milk,cupboard_staple,tins

paprika,cupboard_staple,grams
smoked paprika,cupboard_staple,grams
cumin,cupboard_staple,grams
ground coriander,cupboard_staple,grams
coriander seeds,cupboard_staple,grams
chilli powder,cupboard_staple,grams
cayenne pepper,cupboard_staple,grams
curry powder,cupboard_staple,grams
garam masala,cupboard_staple,grams
turmeric,cupboard_staple,grams
ground ginger,cupboard_staple,grams
ground cinnamon,cupboard_staple,grams
nutmeg,cupboard_staple,grams
allspice,cupboard_staple,grams
mixed herbs,cupboard_staple,grams
italian seasoning,cupboard_staple,grams
bay leaves,cupboard_staple,pieces

chicken breast,recipe_specific,grams
chicken thighs,recipe_specific,grams
whole chicken,recipe_specific,pieces
duck breast,recipe_specific,grams
turkey breast,recipe_specific,grams
beef mince,recipe_specific,grams
pork mince,recipe_specific,grams
lamb mince,recipe_specific,grams
beef steak,recipe_specific,grams
pork chops,recipe_specific,pieces
lamb chops,recipe_specific,pieces
gammon steak,recipe_specific,grams
bacon,recipe_specific,grams
sausages,recipe_specific,pieces
chorizo,recipe_specific,grams
black pudding,recipe_specific,grams
ham,recipe_specific,grams

salmon fillet,recipe_specific,grams
cod fillet,recipe_specific,grams
haddock fillet,recipe_specific,grams
sea bass fillet,recipe_specific,grams
tuna,cupboard_staple,cans
prawns,recipe_specific,grams
mussels,recipe_specific,grams
scallops,recipe_specific,grams

cheddar cheese,recipe_specific,grams
mozzarella,recipe_specific,grams
parmesan,recipe_specific,grams
feta cheese,recipe_specific,grams
halloumi,recipe_specific,grams
goats cheese,recipe_specific,grams
blue cheese,recipe_specific,grams
ricotta,recipe_specific,grams
cream cheese,recipe_specific,grams
double cream,recipe_specific,millilitres
single cream,recipe_specific,millilitres
sour cream,recipe_specific,grams
greek yoghurt,recipe_specific,grams
natural yoghurt,recipe_specific,grams
buttermilk,recipe_specific,millilitres

carrots,recipe_specific,grams
celery,recipe_specific,grams
leeks,recipe_specific,pieces
courgette,recipe_specific,pieces
aubergine,recipe_specific,pieces
bell pepper,recipe_specific,pieces
mushrooms,recipe_specific,grams
spinach,recipe_specific,grams
kale,recipe_specific,grams
broccoli,recipe_specific,grams
cauliflower,recipe_specific,grams
cabbage,recipe_specific,grams
peas,recipe_specific,grams
sweetcorn,recipe_specific,grams
tomatoes,recipe_specific,grams
cherry tomatoes,recipe_specific,grams
cucumber,recipe_specific,pieces
lettuce,recipe_specific,pieces
rocket,recipe_specific,grams
watercress,recipe_specific,grams
spring onions,recipe_specific,grams
sweet potato,recipe_specific,grams
parsnips,recipe_specific,grams
beetroot,recipe_specific,grams
butternut squash,recipe_specific,grams

ginger,recipe_specific,grams
fresh chilli,recipe_specific,pieces
lemongrass,recipe_specific,pieces
lime,recipe_specific,pieces
coriander leaves,recipe_specific,grams
parsley,recipe_specific,grams
basil,recipe_specific,grams
thyme,recipe_specific,grams
rosemary,recipe_specific,grams
mint,recipe_specific,grams
sage,recipe_specific,grams
dill,recipe_specific,grams

tortilla wraps,recipe_specific,pieces
pitta bread,recipe_specific,pieces
naan bread,recipe_specific,pieces
lasagne sheets,recipe_specific,sheets
puff pastry,recipe_specific,sheets
shortcrust pastry,recipe_specific,sheets
filo pastry,recipe_specific,sheets
pizza base,recipe_specific,pieces
noodles,recipe_specific,grams
rice noodles,recipe_specific,grams
udon noodles,recipe_specific,grams

dark chocolate,recipe_specific,grams
milk chocolate,recipe_specific,grams
white chocolate,recipe_specific,grams
chocolate chips,recipe_specific,grams
cocoa nibs,recipe_specific,grams
gelatine sheets,recipe_specific,sheets
food colouring,recipe_specific,teaspoons

saffron,recipe_specific,grams
star anise,recipe_specific,pieces
cardamom pods,recipe_specific,pieces
cloves,recipe_specific,pieces
cinnamon sticks,recipe_specific,pieces
vanilla pod,recipe_specific,pieces';

        $csv = explode("\n", $csv);
        foreach ($csv as $row) {
            $data = explode(",", str_replace("\r", '', $row));

            //Check data 0 is not empty
            if (empty($data[2])) {
                continue;
            }

            //Check data 1 is one of the ingredient types
            if (!in_array($data[1], ['staple', 'cupboard_staple', 'recipe_specific'])) {
                continue;
            }

            //Check data 2 is one of the ingredient uoms
            if (!in_array($data[2], ['grams', 'kilograms', 'litres', 'millilitres', 'pieces', 'cups', 'teaspoons', 'tablespoons', 'tins', 'ounces', 'pounds', 'cans', 'bottles', 'boxes', 'bags', 'sachets', 'rolls', 'sheets', 'squares'])) {
                continue;
            }


            Ingredient::create([
                'name' => ucwords($data[0]),
                'type' => $data[1],
                'uom' => $data[2],
            ]);
        }
    }
}
