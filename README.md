# Connect 4

## Table of Contents

- Περιγραφή API
   
   - Methods
      
- Board
     
      Ανάγνωση Board
      Αρχικοποίηση Board
   
- Piece
    
      Ανάγνωση Θέσης/Πιονιού
      Μεταβολή Θέσης Πιονιού

- Player
    
      Ανάγνωση στοιχείων παίκτη
      Καθορισμός στοιχείων παίκτη

- Status
    
      Ανάγνωση κατάστασης παιχνιδιού

- Entities

      Board
      Players
      Game_status

### Requirements

* PHP
* Mysql
* Apache2

### Gameplay

Το connet4/scor4 είναι ένα παιχνίδι 2 ατόμων. Ο κάθε παίχτης με την σειρά του επιλέγει το χώμα που θέλει ανάμεσα στο Κόκκινο και στο Κίτρινο και το τοποθετεί στον πίνακα (7x6).

### Συντελεστές

Γανιάρης Ευάγγελος

## Περιγραφή API

### Board

```
GET /board/
```

Επιστέφει τον πίνακα με τις κινήσεις που έχουν γίνει.

```
{
  "y": 6,
  "x": 1,
  "piece_color": "Y"
},
    
{
  "y": 6,
  "x": 2,
  "piece_color": "R"
},

```
Αρχικοποίηση Board

```
POST /board/
```
Αρχικοποιεί το Board, δηλαδή το παιχνίδι. Γίνονται reset τα πάντα σε σχέση με το παιχνίδι. Επιστρέφει το Board.

### PLayers

```
POST /players/:p
```
Εισαγωγή παίχτη, όπου το p μπορεί να είναι R = red και Y = yellow

```
{
  "username":"user1"
}
```

```
GET /players/
```
Επιστρέφει τους παίχτες

```
{
  "username": "user1",
  "piece_color": "R",
  "token": "0b0a548ee666192f298a5d533f990aed",
  "last_action": null
}
```

### Json Data

|Field      |Description                        |Required
|---        |---                                |---
|username   |Το username για τον παίκτη p.      |✔️
|color      |To χρώμα που επέλεξε ο παίκτης p.	|✔️


### Status

```
GET /status/
```
Επιστρέφει το στοιχείο status.

## Entities

|Attribute    |Description            |Values
|---          |---                    |---
| y           |H συντεταγμένη του Y   |1-7
| x           |H συντεταγμένη του X   |1-6
| color       |Το χρωμα               |R, Y


## Players

|Attribute    |Description                     |Values
|---          |---                             |---
| username    |Το ονομα του παιχτη             |String
| piece_color |To χρώμα που παίζει ο παίκτης   |R, Y
| token       |To κρυφό token του παίκτη. Επιστρέφεται μόνο τη στιγμή της εισόδου του παίκτη στο παιχνίδι. |HEX
|timestamp    |Δειχνει τον χρονο της τελευταιας κινησης του παιχτη |timestamp

## Status

H κατάσταση παιχνιδιού έχει τα παρακάτω στοιχεία:

|Attribute    |Description                       |Values
|---          |---                               |---
| status      |Κατάσταση                         |not active, initialized, started, ended, aborded
| p_turn      |To χρώμα του παίκτη που παίζει	   |R, Y, Null
| result      |To χρώμα του παίκτη που κέρδισε   |R, Y, Null
|last_change  |Τελευταία αλλαγή/ενέργεια στην κατάσταση του παιχνιδιού |timestamp



