$.ajax(config);

const { useState } = React;

const AlertMessage = (props) => {
  return (
    <div className=" alert alert-warning">
      Doublons détectés:
      <ul className=" text-decoration-none">
        {props.doub.map((item, i) => {
          return <li> {item} </li>;
        })}
      </ul>
    </div>
  );
};

const Item = ({ onRemove }) => {

  //valeur des hors taxes
  const [ht, setHt] = useState([0, 0]);
  const handleHt = (e) => {
    const i = e.selectedIndex - 1;
    // console.log(i);

    setHt([
      zones[i].ht_liv_20 ? zones[i].ht_liv_20 : 0,
      zones[i].ht_liv_40 ? zones[i].ht_liv_40 : 0,
    ]);
  };

  //conteneurs
  const [c, setC] = useState(["", ""]);
  const handleC1 = (e) => {
    setC([e, c[1] + "-"]);
    checkDoubles(c[0], c[1]);
  };
  const handleC2 = (e) => {
    setC([c[0] + "-", e]);
    checkDoubles(c[0], c[1]);
  };

  //notification de control de saisie
  const [a, setA] = useState({ m: true, err: [] });
  function checkDoubles() {
    axios.post(checkUrl, { token: token, data: c }).then((res) => {
      // console.log(res.data);
      setA(res.data);
    });
  }

  return (
    <div className="zoneLab">
      <p className="d-flex align-items-center justify-content-between">
        <span>Zone de livraison</span>

        <div>
          <button
            type="button"
            className="btn btn-light btn-sm rounded delZ"
            onClick={onRemove}
          >
            x
          </button>
        </div>
      </p>
      {a.m ? "" : <AlertMessage doub={a.err} />}
      <div className="d-flex gap-1">
        <div className="flex-grow-1">
          <div className="mb-3">
            <select
              className="form-select form-select-lg"
              name="zone[]"
              required
              onChange={(e) => {
                handleHt(e.target);
              }}
            >
              <option value="" hidden>
                Sélectionnez une zone
              </option>
              {zones.map((item, i) => {
                return (
                  <option value={item.id} key={i}>
                    {item.nom}
                  </option>
                );
              })}
            </select>
          </div>
          <div className="mb-3">
            <input
              type="text"
              className="form-control"
              name="address[]"
              aria-describedby="helpId"
              placeholder="Adresse exacte"
            />
            <div className="text-sm text-muted">
              Laisser vide si l'information est indisponible.
            </div>
          </div>
          <div className="mb-3">
            <input
              type="number"
              className="form-control"
              name="ht_20[]"
              aria-describedby="helpId"
              placeholder="Hors taxe 20'"
              value={ht[0]}
            />
            <div className="text-sm text-muted">
              Laisser vide si l'information est indisponible.
            </div>
          </div>
          <div className="mb-3">
            <textarea
              className="form-control  text-uppercase"
              name="c_20[]"
              rows="2"
              placeholder="Conteneurs 20'"
              onKeyUp={(e) => {
                handleC1(e.target.value);
              }}
              onBlur={(e) => {
                handleC1(e.target.value);
              }}
            >
              {c[0]}
            </textarea>
            <div className="text-sm text-muted ">
              Séparer les conteneurs par des tirés (-). Exemple:
              QWER1234567-ABCD0987654-...
            </div>
          </div>
          <div className="mb-3">
            <input
              type="number"
              className="form-control"
              name="ht_40[]"
              aria-describedby="helpId"
              placeholder="Hors taxe 40'"
              value={ht[1]}
            />
            <div className="text-sm text-muted">
              Laisser vide si l'information est indisponible.
            </div>
          </div>
          <div className="mb-3">
            <textarea
              className="form-control text-uppercase"
              name="c_40[]"
              rows="2"
              placeholder="Conteneurs 40'"
              onKeyUp={(e) => {
                handleC2(e.target.value);
              }}
              onBlur={(e) => {
                handleC2(e.target.value);
              }}
            >
              {c[0]}
            </textarea>
            <div className="text-sm text-muted">
              Séparer les conteneurs par des tirés (-). Exemple:
              QWER1234567-ABCD0987654-...
            </div>
          </div>
        </div>
      </div>
    </div>
  );
};

const ReactAppFromCDN = () => {
  const [stack, setStack] = useState([]);

  const addInStack = () => {
    setStack((prevStack) => [
      ...prevStack,
      <Item onRemove={removeFromStack(prevStack.length)} />,
    ]);
  };

  const removeFromStack = (index) => () => {
    setStack((prevStack) => prevStack.filter((item, i) => i !== index));
  };

  // console.log(stack);
  return (
    <div>
      <div className="row row-cols-md-2 row-cols-xl-3 gx-3 gy-3 mb-3">
        {stack.map((item, i) => {
          return (
            <div key={i}>
              {React.cloneElement(item, { onRemove: removeFromStack(i) })}
            </div>
          );
        })}
      </div>
      <div className="text-center mb-3">
        <button
          type="button"
          className="btn btn-secondary btn-sm"
          onClick={addInStack}
        >
          Ajouter une zone
        </button>
      </div>
      <div className="d-flex justify-content-center">
        <button type="submit" className="btn btn-primary">
          Créer la facture
        </button>
      </div>
    </div>
  );
};

ReactDOM.render(<ReactAppFromCDN />, document.getElementById("yankee"));
