
// Nombre del alumno Alberto Pascual y Andres Romero
// Usuario del Juez PC07


#include <iostream>
#include <iomanip>
#include <fstream>
#include<vector>
#include <cstring>
using namespace std;

const int noOp = 0;
const int set0 = 2;
const int set1 = 1;
const int inverse = 3;



const int MAX_P = 1024000;

class SegmentTree {

private:
    vector<int> st;
    vector<int> lazy;
    int tam; // Numero de hojas que manejamos
public:

    SegmentTree(int maxN) {
        //  st.reserve(4 * maxN + 10);//solo reservar da error en visual studio en modo debug
        st.assign(4 * maxN + 10, 0);
        lazy.assign(4 * maxN + 10, 0);
    }

    void build(std::vector<int> const& values, int n) {
        this->tam = n;
        build(values, 1, 0, n - 1);

    }

    void build(std::vector<int> const& values, int p, int l, int r) {

        if (l == r) {
            st[p] = values[l]; return;
        }
        int mitad = (l + r) / 2;
        build(values, 2 * p, l, mitad);
        build(values, 2 * p + 1, mitad + 1, r);
        st[p] = st[2 * p] + st[2 * p + 1];

    }

    int query(int i, int j) {
        return query(1, 0, tam - 1, i, j);
    }

    int query(int v, int L, int R, int i, int j) {
        if (lazy[v] != noOp) pushLazyUpdate(v, L, R);

        if ((j < L) || (R < i))
            return 0;

        if (i <= L && R <= j)
            return st[v];

        int mitad = (L + R) / 2;
        return query(2 * v, L, mitad, i, j) +
            query(2 * v + 1, mitad + 1, R, i, j);
    }

    void setLazyUpdate(int v, int op) {
        // Mezclamos
        // Importante +=: el nodo podria tener
        // otras operaciones pendientes anteriores
       // lazy[v] += value;

        if (op == inverse) {
            if (lazy[v] == set0) lazy[v] = set1;
            else if (lazy[v] == set1) lazy[v] = set0;
            else if (lazy[v] == inverse) lazy[v] = noOp;
            else if(lazy[v] == noOp) lazy[v] = inverse;
        }
        else if (op > 0) {
            lazy[v] = op;
        }

    }

    void pushLazyUpdate(int v, int L, int R) {

        if (lazy[v] == set0) st[v] = 0;
        else if (lazy[v] == set1) st[v] = (R - L + 1);
        else if (lazy[v] == inverse) st[v] = R - L + 1 - st[v];

        if (L != R) {
            // Tenemos hijos
            int m = (L + R) / 2;
            setLazyUpdate(2 * v, lazy[v]);
            setLazyUpdate(2 * v + 1, lazy[v]);
        }

        lazy[v] = noOp; //no
    } 

    void updateRange(int a, int b, int v) {
        updateRange(1, 0, tam - 1, a, b, v);
    }

    void updateRange(int v, int L, int R,
        int a, int b, int op) {
        // Resolvemos posibles operaciones pendientes
        pushLazyUpdate(v, L, R);
        if ((b < L) || (R < a)) return;
        // �Intervalo afectado por completo?
        if ((a <= L) && (R <= b)) {
            // Nos aplicamos la operacion y propagamos la
            // pereza a los hijos. Para evitar copiar/pegar,
            // lo hacemos aplicandonos la pereza, y luego
            // resolviendola
 
            setLazyUpdate(v, op);
            pushLazyUpdate(v, L, R);

            return;
        }

        // Intervalo no afectado por completo. No podemos
        // ser perezosos. Aplicamos la operacion en
        // los hijos
        int m = (L + R) / 2;
        updateRange(2 * v, L, m, a, b, op);
        updateRange(2 * v + 1, m + 1, R, a, b, op);
        // Combinamos
        st[v] = st[2 * v] + st[2 * v + 1];
    }

};


// Resuelve un caso de prueba, leyendo de la entrada la
// configuración, y escribiendo la respuesta
void resuelveCaso() {
    // leer los datos de la entrada
    int pares;
    std::cin >> pares;

    std::vector<int> datos;

    for (int i = 0; i < pares; i++) {

        int n;
        std::cin >> n;

        std::string s;
        std::cin >> s;

        for (int j = 0; j < n; j++) {
            for (int k = 0; k < s.size(); k++) {
                datos.push_back(s[k] - 48);
            }
        }

    }

    SegmentTree st(datos.size());
    st.build(datos, datos.size());


    int consultas;
    std::cin >> consultas;
    int q = 1;
    for (int i = 0; i < consultas; i++) {

        char opt;
        int arg1, arg2;
        std::cin >> opt >> arg1 >> arg2;



        switch (opt)
        {
        case 'F':
            st.updateRange(arg1, arg2, 1);
            break;
        case 'I':
            st.updateRange(arg1, arg2, 3);
            break;
        case 'S':
            std::cout << "Q" << q++ << ": " << st.query(arg1, arg2) << "\n";
            break;
        case 'E':
            st.updateRange(arg1, arg2, 2);
            break;

        default:
            break;
        }

    }
}

int main() {
    // Para la entrada por fichero.
    // Comentar para acepta el reto
#ifndef DOMJUDGE
    std::ifstream in("datos2.txt");
    auto cinbuf = std::cin.rdbuf(in.rdbuf()); //save old buf and redirect std::cin to casos.txt
#endif 


    int numCasos;
    std::cin >> numCasos;
    for (int i = 1; i <= numCasos; ++i) {
        cout << "Case " << i << ":" << endl;
        resuelveCaso();
    }
        


    // Para restablecer entrada. Comentar para acepta el reto
#ifndef DOMJUDGE // para dejar todo como estaba al principio
    std::cin.rdbuf(cinbuf);
    system("PAUSE");
#endif

    return 0;
}